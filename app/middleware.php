<?php 

//for add global Middleware

//When response status 404, auto call not found page
$app->add(new \MBS\Middlewares\NotFoundMiddleware($container));

//csrf
$app->add(new \MBS\Middlewares\CsrfMiddleware($container));
$app->add($container->csrf);