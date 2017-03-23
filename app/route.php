<?php 

$namespace = 'MBS\Controllers';

use MBS\Middlewares\UserMiddleware;
use MBS\Middlewares\ShippingMiddleware;
use MBS\Middlewares\AdminMiddleware;

$app->get('/', $namespace. '\HomeController:index')->setName('home')->add(new ShippingMiddleware($container));

$app->get('/admin/login', $namespace.'\AdminController:getSignIn')->setName('admin.login');
$app->post('/admin/login', $namespace.'\AdminController:postSignIn');

$app->group('/admin', function () use ($app,$namespace) {
	$app->get('', $namespace.'\AdminController:index')->setName('admin.index');
	$app->get('/logout', $namespace.'\AdminController:Logout')->setName('admin.logout');
	$app->get('/change_password', $namespace. '\AdminController:getChangePassword')->setName('admin.change_password');
})->add(new AdminMiddleware($container));

$app->get('/register', $namespace.'\UserController:getRegister')->setName('user.register');
$app->post('/register', $namespace.'\UserController:postRegister');

$app->get('/login', $namespace. '\UserController:getLogin')->setName('user.login');
$app->post('/login', 'MBS\Controllers\UserController:postLogin');

$app->get('/reset_password', $namespace. '\UserController:getResetPassword')->setName('user.reset_password');
$app->post('/reset_password', $namespace. '\UserController:postResetPassword');

$app->get('/cart', $namespace. '\CartController:index')->setName('cart.index');
$app->post('/cart', $namespace. '\CartController:add');

//user must login before access this route
$app->group('', function () use ($app, $namespace) {
	$app->get('/logout', $namespace. '\UserController:getLogout')->setName('user.logout');
	$app->get('/edit', $namespace. '\UserController:getEdit')->setName('user.edit');
	$app->post('/edit', $namespace. '\UserController:postEdit')->setName('user.edit');
	$app->get('/my_account', $namespace. '\UserController:getAccount')->setName('user.account');
})->add(new UserMiddleware($container));