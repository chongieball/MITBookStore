<?php 

$namespace = 'MBS\Controllers';

$app->get('/home', $namespace. '\HomeController:index')->setName('home');
$app->get('/admin', $namespace.'\AdminController:index')->setName('admin.index');

$app->get('/register', $namespace.'\UserController:getRegister')->setName('user.register');
$app->post('/register', $namespace.'\UserController:postRegister');

$app->get('/login', $namespace. '\UserController:getLogin')->setName('user.login');
$app->post('/login', $namespace. '\UserController:postLogin');

