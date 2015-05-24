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
    
    $randomNum = rand(0,100);

    $createdMessage = $app->createMessage($username, $body, base64_encode(file_get_contents($app['icon_image_path'])));
    
    if($randomNum < 20){
        $createdMessage = $app->createMessage(Bot_HOGE, kyou, base64_encode(file_get_contents($app['icon_image_path'])));
    }else if($randomNum < 90){
        $createdMessage = $app->createMessage(Bot_HOGE, kichi, base64_encode(file_get_contents($app['icon_image_path'])));
    }else{
        $createdMessage = $app->createMessage(Bot_HOGE, daikichi, base64_encode(file_get_contents($app['icon_image_path'])));
    }
    

    return $app->json($createdMessage);
});

return $app;
