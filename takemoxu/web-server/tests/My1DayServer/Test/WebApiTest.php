<?php

namespace My1DayServer\Test;

use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class WebApiTest extends WebTestCase
{
    public function createApplication()
    {
        return require __DIR__.'/../../../app.php';
    }

    public function testGetMessages()
    {
        $client = $this->createClient();
        $client->request('GET', '/messages');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertValidResponseBySchema($client->getResponse(), 'message', 2);
    }

    public function testGetMessage()
    {
        $client = $this->createClient();
        $client->request('GET', '/messages/1');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertValidResponseBySchema($client->getResponse(), 'message', 1);
    }

    public function testPostMessage()
    {
        $content = json_encode([
            'username' => 'example-username',
            'body' => 'example-body',
        ]);

        $client = $this->createClient();
        $client->request('POST', '/messages', [], [], ['CONTENT_TYPE' => 'application/json'], $content);

        $response = $client->getResponse();
        $json = json_decode($response->getContent(), true);

        $this->assertTrue($response->isOk());
        $this->assertValidResponseBySchema($response, 'message', 0);
        $this->assertEquals('example-username', $json['username']);
        $this->assertEquals('example-body', $json['body']);
    }

    public function testPostMessageRequiresApplicationJson()
    {
        $content = json_encode([
            'username' => 'example-username',
            'body' => 'example-body',
        ]);

        $client = $this->createClient();
        $client->request('POST', '/messages', [], [], [], $content);

        $response = $client->getResponse();
        $json = json_decode($response->getContent(), true);

        $this->assertEquals($response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $this->assertEquals('invalid-json', $json[0]['code']);
    }

    public function testPostMessageRequiresValidJson()
    {
        $content = '}This is not a valid JSON encoded text!{';

        $client = $this->createClient();
        $client->request('POST', '/messages', [], [], ['CONTENT_TYPE' => 'application/json'], $content);

        $response = $client->getResponse();
        $json = json_decode($response->getContent(), true);

        $this->assertEquals($response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $this->assertEquals('invalid-json', $json[0]['code']);
    }

    public function testPutMessageIsNotAllowed()
    {
        $client = $this->createClient();
        $client->request('PUT', '/messages');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    public function testDeleteMessageIsNotAllowed()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/messages');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    public function assertValidResponseBySchema($response, $category, $index = null, $baseSchema = null)
    {
        $validator = $this->app['schema_validator'];
        $validator->validateResponseBySchema($response->getContent(), $category, $index, $baseSchema);

        $this->assertTrue($validator->isValid(), join(PHP_EOL, array_map(function ($v) {
            return '* ' . $v['property'] . ' : ' . $v['message'];
        }, $validator->getErrors())));
    }
}
