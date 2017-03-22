<?php 

$namespace = 'MBS\Controllers';

use MBS\Middlewares\UserMiddleware;
use MBS\Middlewares\ShippingMiddleware;

$app->get('/', $namespace. '\HomeController:index')->setName('home')->add(new ShippingMiddleware($container));
$app->get('/admin', $namespace.'\AdminController:index')->setName('admin.index');

$app->get('/register', $namespace.'\UserController:getRegister')->setName('user.register');
$app->post('/register', $namespace.'\UserController:postRegister');

$app->get('/login', $namespace. '\UserController:getLogin')->setName('user.login');
$app->post('/login', 'MBS\Controllers\UserController:postLogin');

$app->get('/reset_password', $namespace. '\UserController:getResetPassword')->setName('user.reset_password');
$app->post('/reset_password', $namespace. '\UserController:postResetPassword');

//user must login before access this route
$app->group('', function () use ($app, $namespace) {
	$app->get('/logout', $namespace. '\UserController:getLogout')->setName('user.logout');
	$app->get('/edit', $namespace. '\UserController:getEdit')->setName('user.edit');
	$app->post('/edit', $namespace. '\UserController:postEdit')->setName('user.edit');
	$app->get('/my_account', $namespace. '\UserController:getAccount')->setName('user.account');
	$app->get('/cart', $namespace. '\CartController:index')->setName('cart.index');
	$app->post('/cart', $namespace. '\CartController:add');
})->add(new UserMiddleware($container));