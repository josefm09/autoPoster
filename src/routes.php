<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml');
});

$app->post('/greet', function (Request $request, Response $response, array $args) {
    $name = $request->getParsedBodyParam('name', 'World');
    $greetingMessage = "Hello, " . htmlspecialchars($name) . "!";
    $data = [
        'name' => $name,
        'greetingMessage' => $greetingMessage
    ];
    return $this->renderer->render($response, 'index.phtml', $data);
});
