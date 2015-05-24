<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Debug\ErrorHandler;

ErrorHandler::register();

date_default_timezone_set('UTC');

$app = require_once __DIR__.'/../app.php';
$app->run();
