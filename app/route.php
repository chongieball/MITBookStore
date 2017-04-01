<?php

$namespace = 'MBS\Controllers';

use MBS\Middlewares\UserMiddleware;
use MBS\Middlewares\ShippingMiddleware;
use MBS\Middlewares\AdminMiddleware;

$app->get('/', $namespace. '\HomeController:index')->setName('home')
    ->add(new ShippingMiddleware($container));

//--------------FOR ADMIN
$app->get('/admin/login', $namespace.'\AdminController:getSignIn')
    ->setName('admin.login');
$app->post('/admin/login', $namespace.'\AdminController:postSignIn');

$app->get('/admin/logout', $namespace.'\AdminController:Logout')
    ->setName('admin.logout');

$app->group('/admin', function () use ($app,$namespace) {
	$app->get('', $namespace.'\AdminController:index')->setName('admin.index');

	$app->get('/change_password', $namespace. '\AdminController:getChangePassword')->setName('admin.change_password');

//----------------BOOK----------------------------
	$app->get('/book', $namespace.'\BookController:index')
	    ->setName('book.index');


	$app->get('/book/add', $namespace.'\BookController:getAdd')
	    ->setName('book.add');
	$app->post('/book/add', $namespace.'\BookController:postAdd');

	$app->post('/book/softdelete', $namespace.'\BookController:softDelete')->setName('book.softdelete');

	$app->get('/book/update/{id}', $namespace.'\BookController:getUpdate')
	    ->setName('book.update');
	$app->post('/book/update/{id}', $namespace.'\BookController:postUpdate');

	$app->get('/book/detail/{id}', $namespace.'\BookController:detail')
	    ->setName('book.detail');

	$app->get('/book/detail/author/{id}', $namespace.'\AuthorController:getAddAuthorInBook')->setName('book.add.author');
	$app->post('/book/detail/author/{id}', $namespace.'\AuthorController:postAddAuthorInBook');

	$app->get('/book/detail/category/{id}', $namespace.'\CategoryController:getAddCategoryInBook')
	    ->setName('book.add.category');
    $app->post('/book/detail/category/{id}', $namespace.'\CategoryController:postAddCategoryInBook');

    $app->get('/book/image/{id}', $namespace.'\BookController:getChangeImage')
        ->setName('book.change.image');
	$app->post('/book/image/{id}', $namespace.'\BookController:postChangeImage');

	$app->get('/book/arsip', $namespace.'\BookController:arsip')
	    ->setName('book.arsip');

	$app->post('/book/delete', $namespace.'\BookController:hardDelete')
	    ->setName('book.delete');

	$app->post('/book/restore', $namespace.'\BookController:restore')
	    ->setName('book.restore');

// -----------------AUTHOR
    $app->get('/author', $namespace.'\AuthorController:index')
        ->setName('author.index');
	$app->post('/author', $namespace.'\AuthorController:softDelete');

	$app->get('/author/add', $namespace.'\AuthorController:getAdd')
	    ->setName('author.add');
	$app->post('/author/add', $namespace.'\AuthorController:postAdd');

	$app->get('/author/update/{id}', $namespace.'\AuthorController:getUpdate')->setName('author.update');
	$app->post('/author/update/{id}', $namespace.'\AuthorController:postUpdate');

	$app->get('/author/arsip', $namespace.'\AuthorController:arsip')
	    ->setName('author.arsip');

	$app->post('/author/arsip/delete', $namespace.'\AuthorController:hardDelete')->setName('author.delete');

	$app->post('/author/arsip/restore', $namespace.'\AuthorController:restore')->setName('author.restore');

// ----------------CATEGORY
	$app->get('/category', $namespace.'\CategoryController:index')
	    ->setName('category.index');
	$app->post('/category', $namespace.'\CategoryController:softDelete');

	$app->get('/category/add', $namespace.'\CategoryController:getAdd')
        ->setName('category.add');
	$app->post('/category/add', $namespace.'\CategoryController:postAdd');

	$app->get('/category/update/{id}', $namespace.'\CategoryController:getUpdate')->setName('category.update');
	$app->post('/category/update/{id}', $namespace.'\CategoryController:postUpdate');

	$app->get('/category/arsip', $namespace.'\CategoryController:arsip')
	    ->setName('category.arsip');

	$app->post('/category/archive/delete', $namespace.'\CategoryController:hardDelete')->setName('category.delete');

	$app->post('/category/archive/restore', $namespace.'\CategoryController:restore')->setName('category.restore');

// ----------PUBLISHER----------------------------------------------------------
	$app->get('/publisher', $namespace.'\PublisherController:index')
	    ->setName('publisher.index');
	$app->post('/publisher', $namespace.'\PublisherController:softDelete');

	$app->get('/publisher/add', $namespace.'\PublisherController:getAdd')
        ->setName('publisher.add');
	$app->post('/publisher/add', $namespace.'\PublisherController:postAdd');

	$app->get('/publisher/update/{id}', $namespace.'\PublisherController:getUpdate')->setName('publisher.update');
	$app->post('/publisher/update/{id}', $namespace.'\PublisherController:postUpdate');

	$app->get('/publisher/arsip', $namespace.'\PublisherController:arsip')
        ->setName('publisher.arsip');

	$app->post('/publisher/archive/delete', $namespace.'\PublisherController:hardDelete')->setName('publisher.delete');

	$app->post('/publisher/archive/restore', $namespace.'\PublisherController:restore')->setName('publisher.restore');
})->add(new AdminMiddleware($container));

//-------------------FOR USER
$app->get('/register', $namespace.'\UserController:getRegister')
    ->setName('user.register');
$app->post('/register', $namespace.'\UserController:postRegister');

$app->get('/login', $namespace. '\UserController:getLogin')
    ->setName('user.login');
$app->post('/login', 'MBS\Controllers\UserController:postLogin');

$app->get('/reset_password', $namespace. '\UserController:getResetPassword')
    ->setName('user.reset_password');
$app->post('/reset_password', $namespace. '\UserController:postResetPassword');

//user must login before access this route
$app->group('', function () use ($app, $namespace) {
	$app->get('/logout', $namespace. '\UserController:getLogout')
	    ->setName('user.logout');

	$app->get('/edit', $namespace. '\UserController:getEdit')
	    ->setName('user.edit');
	$app->post('/edit', $namespace. '\UserController:postEdit');

	$app->get('/my_account', $namespace. '\UserController:getAccount')
	    ->setName('user.account');
	    
	$app->get('/order', $namespace. '\OrderController:index')->setName('order.index');

	$app->get('/invoice', $namespace. '\InvoiceController:index')->setName('invoice.index');
	$app->post('/invoice', $namespace. '\InvoiceController:add');
})->add(new UserMiddleware($container));

$app->get('/cart', $namespace. '\CartController:index')->setName('cart.index');
$app->post('/cart', $namespace. '\CartController:add');
$app->post('/cart/update/{slug}', $namespace. '\CartController:update')
    ->setName('cart.update');

$app->post('/order', $namespace. '\OrderController:order');

$app->get('/book', $namespace. '\BookController:search')->setName('book.search');

$app->get('/{slug}', $namespace. '\BookController:getSlug')
    ->setName('book.slug');