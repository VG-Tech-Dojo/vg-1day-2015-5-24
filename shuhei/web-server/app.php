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

    if ($data['body'] == "uranai") {
      switch (mt_rand (0, 9)) {
        case 0:
        case 1:
          $createdMessage = $app->createMessage("Bot_uranai", "daikichi", base64_encode(file_get_contents($app['icon_image_path'])));
          break;
        case 2:
        case 3:
        case 4:
        case 5:
        case 6:
        case 7:
          $createdMessage = $app->createMessage("Bot_uranai", "kichi", base64_encode(file_get_contents($app['icon_image_path'])));
          break;
        case 8:
        case 9:
          $createdMessage = $app->createMessage("Bot_uranai", "kyou", base64_encode(file_get_contents($app['icon_image_path'])));
          break;
        default:
          $createdMessage = $app->createMessage("Bot_uranai", "kichi", base64_encode(file_get_contents($app['icon_image_path'])));
          break;
        }
    } else {
      $createdMessage = $app->createMessage($username, $body, base64_encode(file_get_contents($app['icon_image_path'])));
      $createdMessage = $app->createMessage("Bot", $body, base64_encode(file_get_contents($app['icon_image_path'])));
    }

    return $app->json($createdMessage);
});

return $app;
