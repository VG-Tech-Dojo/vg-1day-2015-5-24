<?php

use Symfony\Component\HttpFoundation\Request;

$app = new My1DayServer\Application();
$app['debug'] = true;

$app->get('/messages', function () use ($app) {
    $messages = $app->getAllMessages();

    return $app->json($messages);
});

$app->get('/messages/{id}', function ($id) use ($app) {
    $message = $app->getMessage($id);

    return $app->json($message);
});

$app->post('/messages', function (Request $request) use ($app) {
    $data = $app->validateRequestAsJson($request);

    $username = isset($data['username']) ? $data['username'] : '';
    $body = isset($data['body']) ? $data['body'] : '';

    $createdMessage = $app->createMessage($username, $body, base64_encode(file_get_contents($app['icon_image_path'])));

    if ($body == "uranai") {
        $randomNum = rand(0, 100);
        if ($randomNum < 10){
            $createdMessage = $app->createMessage('UranaiBot', "Hi! " . $username . ", you are [daikichi]", base64_encode(file_get_contents($app['icon_image_path'])));
        }elseif ($randomNum < 90) {
            $createdMessage = $app->createMessage('UranaiBot', "Hi! " . $username . ", you are [kichi]", base64_encode(file_get_contents($app['icon_image_path'])));
        }else{
            $createdMessage = $app->createMessage('UranaiBot', "Hi! " . $username . ", you are [kyou]", base64_encode(file_get_contents($app['icon_image_path'])));
        }
    } else {
        $createdMessage = $app->createMessage('Bot', $body, base64_encode(file_get_contents($app['icon_image_path'])));
    }

    return $app->json($createdMessage);
});

return $app;
