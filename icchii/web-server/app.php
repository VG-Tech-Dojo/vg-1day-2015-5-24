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

    if(strstr($body, 'uranai')){

    	$i = rand(0,2);
    	if($i == 0){
    		$createdMessage = $app->createMessage($username, "daikichi", base64_encode(file_get_contents($app['icon_image_path'])));
    	}else if($i == 1){
    		$createdMessage = $app->createMessage($username, "kichi", base64_encode(file_get_contents($app['icon_image_path'])));
    	}else if($i == 2){
    		$createdMessage = $app->createMessage($username, "kyou", base64_encode(file_get_contents($app['icon_image_path'])));
    	}
    }else if(strstr($body, 'sum')){
    	$pieces = explode(" ", $body);
    	$count = $pieces[1];
		for($i = 2; $i < count($pieces) ; $i++){
			$count = $count + $pieces[$i];
		}
		$createdMessage = $app->createMessage("Cal", $count, base64_encode(file_get_contents($app['icon_image_path'])));

    }else if(strstr($body, 'sub')){
		$pieces = explode(" ", $body);
    	$count = $pieces[1];
		for($i = 2 ; $i < count($pieces) ; $i++){
			$count = $count - $pieces[$i];
		}
		$createdMessage = $app->createMessage("Cal", $count, base64_encode(file_get_contents($app['icon_image_path'])));
    }else if(strstr($body, 'dev')){
		$pieces = explode(" ", $body);
    	$count = $pieces[1];
		for($i = 2 ; $i < count($pieces) ; $i++){
			$count = $count / $pieces[$i];
		}
		$createdMessage = $app->createMessage("Cal", $count, base64_encode(file_get_contents($app['icon_image_path'])));
    }else if(strstr($body, 'mul')){
		$pieces = explode(" ", $body);
    	$count = $pieces[1];
		for($i = 2 ; $i < count($pieces) ; $i++){
			$count = $count * $pieces[$i];
		}
		$createdMessage = $app->createMessage("Cal", $count, base64_encode(file_get_contents($app['icon_image_path'])));
    }else{
    	 $createdMessage = $app->createMessage($username, $body, base64_encode(file_get_contents($app['icon_image_path'])));
    }

    return $app->json($createdMessage);
});

return $app;
