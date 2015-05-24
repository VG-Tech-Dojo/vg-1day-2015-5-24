<?php

namespace My1DayServer;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpFoundation\Response;

use My1DayServer\Exception\ApiExceptionInterface;
use My1DayServer\Exception\InvalidJsonApiException;

class Application extends \Silex\Application
{
    protected $logger;
    protected $tz;

    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this->configureLogger();
        $this->configureDatabase();
        $this->configureError();
        $this->configureApiSchemaValidator();
        $this->configureDefaultIconImagePath();

        $this->configureRepository();
    }

    public function configureLogger()
    {
        $this->logger = new Logger('api');
        $this->logger->pushHandler(new StreamHandler(__DIR__.'/../../log/api.log', Logger::WARNING));
    }

    public function configureDatabase()
    {
        $this['db_path'] = __DIR__.'/../../db/api.db';
        $this['db'] = function ($app) {
            $config = new \Doctrine\DBAL\Configuration();
            return \Doctrine\DBAL\DriverManager::getConnection([
                'driver' => 'pdo_sqlite',
                'path' => $app['db_path'],
            ], $config);
        };
    }

    public function configureError()
    {
        $app = $this;
        $this->error(function (\Exception $e, $code) use ($app) {
            $errors = [];

            if ($e instanceof NotFoundHttpException || $e instanceof MethodNotAllowedHttpException) {
                $code = Response::HTTP_NOT_FOUND;
                $errors[] = [
                    'code'    => 'not-found',
                    'message' => '指定されたリソースが見つかりません。',
                ];
            }

            if ($e instanceof ApiExceptionInterface) {
                $code = $e->getHttpStatusCode();
                $errors[] = [
                    'code'    => $e->getErrorCode(),
                    'message' => $e->getMessage(),
                ];
            }

            if (empty($errors)) {
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
                $errors[] = [
                    'code' => 'unexpected',
                    'message' => $app['debug'] ? (string)$e : '予期しないエラーが発生しました。',
                ];
            }

            $level = Logger::WARNING;
            if ($code >= 400 && $code <= 499) {
                $level = Logger::NOTICE;
            } elseif ($code >= 500 && $code <= 599) {
                $level = Logger::ERROR;
            }

            $app->log((string)$e, $level);

            return $app->json($errors, $code);
        });
    }

    public function configureRepository()
    {
        $this['repository.message'] = function($app) { return new Repository\MessageRepository($app['db']); };
    }

    public function configureApiSchemaValidator()
    {
        $this['schema_validator'] = new ApiSchemaValidator();
        $this['schema_validator']->setDefaultSchemaByLocation('file://'.realpath(__DIR__.'/../../doc/schema.json'));
        $this['schema_validator']->setRefResolver(new \JsonSchema\RefResolver());
    }

    public function configureDefaultIconImagePath()
    {
        $this['icon_image_path'] = realpath(__DIR__.'/../../resource/default.jpg');
    }

    public function json($data = [], $status = 200, array $headers = [])
    {
        $result = parent::json($data, $status, array_merge($headers, [
            'Content-Type' => 'application/json; charset=utf-8',
            'Access-Control-Allow-Origin' => '*',
        ]));
        $result->setEncodingOptions(
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT  // Content-Sniffing を悪用した XSS に対する保険的な対策
            | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT // レスポンスの可読性維持のために Unicode 文字は過剰エスケープせず、空白文字で整形する
        );

        return $result;
    }

    public function log($message, $level = Logger::INFO, $context = [])
    {
        return $this->logger->addRecord($level, $message, $context);
    }

    public function getAllMessages()
    {
        $messages = $this['repository.message']->getAllMessages();
        foreach ($messages as $key => $message) {
            $messages[$key] = $this->transformMessageFormatForJsonApi($message);
        }

        return $messages;
    }

    public function getMessage($id)
    {
        $message = $this['repository.message']->getMessage($id);

        return $this->transformMessageFormatForJsonApi($message);
    }

    public function createMessage($username, $body, $icon)
    {
        $id = $this['repository.message']->createMessage([
            'username' => $username,
            'body' => $body,
            'icon' => $icon,
        ]);

        return $this->getMessage($id);
    }

    protected function getBaseTimezone()     
    {                                        
        if ($this->tz !== null) {
            return $this->tz;
        }

        $this->tz = new \DateTimeZone('UTC');

        return $this->tz;
    }

    protected function transformDateTimeFormat($datetime)
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $datetime, $this->getBaseTimezone())
            ->format('Y-m-d\TH:i:s\Z');
    }

    protected function transformMessageFormatForJsonApi($message)
    {
        $message['id'] = (int)$message['id'];
        $message['created_at'] = $this->transformDateTimeFormat($message['created_at']);
        $message['updated_at'] = $this->transformDateTimeFormat($message['updated_at']);

        return $message;
    }

    public function validateRequestAsJson($request)
    {
        $result = json_decode((string)$request->getContent(), true);
        $error = json_last_error();
        if ($result === null && $error !== JSON_ERROR_NONE) {
            throw new InvalidJsonApiException('指定された JSON のパースに失敗しました。');
        }

        return $result;
    }
}
