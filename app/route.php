<?php

$namespace = 'MBS\Controllers';

$app->get('/home', $namespace. '\HomeController:index')->setName('home');
$app->get('/admin', $namespace.'\AdminController:index')->setName('admin.index');

$app->get('/register', $namespace.'\UserController:getRegister')->setName('user.register');
$app->post('/register', $namespace.'\UserController:postRegister');

$app->get('/login', $namespace. '\UserController:getLogin')->setName('user.login');
$app->post('/login', $namespace. '\UserController:postLogin');

$app->get('/admin/admin', $namespace.'\adminController:index')
    ->setName('admin.index');

$app->get('/admin/categorybook', $namespace.'\CategoryBookController:index')
    ->setName('category.book.index');

$app->get('/admin/authorbook', $namespace.'\AuthorBookController:index')
        ->setName('author.book.index');

$app->get('/admin/book/detail/author/{id}', $namespace.'\AuthorBookController:getAdd')
        ->setName('book.add.author');

$app->get('/admin/book/detail/author/post/{id}', $namespace.'\AuthorBookController:postAdd')
        ->setName('book.post.author');

$app->get('/admin/book/detail/category/{id}', $namespace.'\CategoryBookController:getAdd')
        ->setName('book.add.category');

$app->get('/admin/book/detail/category/post/{id}', $namespace.'\CategoryBookController:postAdd')
        ->setName('book.post.category');
// -----------------------------------------------------------------------------
$app->get('/admin/book', $namespace.'\BookController:index')
    ->setName('book.index');

$app->get('/admin/book/', $namespace.'\BookController:index')
    ->setName('book.index');

$app->get('/admin/book/detail/{id}', $namespace.'\BookController:detail')
        ->setName('book.detail');

$app->get('/admin/book/arsip', $namespace.'\BookController:arsip')
        ->setName('book.arsip');

$app->get('/admin/book/arsip/', $namespace.'\BookController:arsip')
        ->setName('book.arsip');

$app->get('/admin/book/add', $namespace.'\BookController:getAdd')
        ->setName('book.add');

$app->post('/admin/book/postadd', $namespace.'\BookController:postAdd');

$app->post('/admin/book/softdelete', $namespace.'\BookController:softDelete');

$app->post('/admin/book/delete', $namespace.'\BookController:hardDelete')
        ->setName('book.delete');

$app->post('/admin/book/restore', $namespace.'\BookController:restore')
        ->setName('book.restore');

$app->get('/admin/book/update/{id}', $namespace.'\BookController:getUpdate')
        ->setName('book.update');

$app->post('/admin/book/postupdate/{id}', $namespace.'\BookController:postUpdate')
        ->setName('book.postupdate');

$app->get('/admin/book/change/{id}', $namespace.'\BookController:getChange')
        ->setName('book.change');

$app->post('/admin/book/postchange/{id}', $namespace.'\BookController:postChange')
        ->setName('book.postchange');
// -----------------------------------------------------------------------------
$app->get('/admin/category', $namespace.'\CategoryController:index')
    ->setName('category.index');

$app->get('/admin/category/', $namespace.'\CategoryController:index')
    ->setName('category.index');

$app->get('/admin/category/arsip', $namespace.'\CategoryController:arsip')
        ->setName('category.arsip');

$app->get('/admin/category/arsip/', $namespace.'\CategoryController:arsip')
        ->setName('category.arsip');

$app->get('/admin/category/add', $namespace.'\CategoryController:getAdd')
        ->setName('category.add');

$app->post('/admin/category/postadd', $namespace.'\CategoryController:postAdd');

$app->post('/admin/category/softdelete', $namespace.'\CategoryController:softDelete');

$app->post('/admin/category/delete', $namespace.'\CategoryController:hardDelete')
        ->setName('category.delete');

$app->post('/admin/category/restore', $namespace.'\CategoryController:restore')
        ->setName('category.restore');

$app->get('/admin/category/update/{id}', $namespace.'\CategoryController:getUpdate')
        ->setName('category.update');

$app->post('/admin/category/postupdate/{id}', $namespace.'\CategoryController:postUpdate')
        ->setName('category.postupdate');
// -----------------------------------------------------------------------------
$app->get('/admin/author', $namespace.'\AuthorController:index')
    ->setName('author.index');

$app->get('/admin/author/', $namespace.'\AuthorController:index')
        ->setName('author.index');

$app->get('/admin/author/arsip', $namespace.'\AuthorController:arsip')
        ->setName('author.arsip');

$app->get('/admin/author/arsip/', $namespace.'\AuthorController:arsip')
            ->setName('author.arsip');

$app->get('/admin/author/add', $namespace.'\AuthorController:getAdd')
        ->setName('author.add');

$app->post('/admin/author/postadd', $namespace.'\AuthorController:postAdd');

$app->post('/admin/author/softdelete', $namespace.'\AuthorController:softDelete');

$app->post('/admin/author/delete', $namespace.'\AuthorController:hardDelete')
    ->setName('author.delete');

$app->post('/admin/author/restore', $namespace.'\AuthorController:restore')
    ->setName('author.restore');

$app->get('/admin/author/update/{id}', $namespace.'\AuthorController:getUpdate')
        ->setName('author.update');

$app->post('/admin/author/postupdate/{id}', $namespace.'\AuthorController:postUpdate')
        ->setName('author.postupdate');
// -----------------------------------------------------------------------------
$app->get('/admin/publisher', $namespace.'\PublisherController:index')
    ->setName('publisher.index');

$app->get('/admin/publisher/', $namespace.'\PublisherController:index')
        ->setName('publisher.index');

$app->get('/admin/publisher/read/{term}', $namespace.'\PublisherController:readAjax')
            ->setName('publisher.read');

$app->get('/admin/publisher/arsip', $namespace.'\PublisherController:arsip')
        ->setName('publisher.arsip');

$app->get('/admin/publisher/arsip/', $namespace.'\PublisherController:arsip')
        ->setName('publisher.arsip');

$app->get('/admin/publisher/add', $namespace.'\PublisherController:getAdd')
        ->setName('publisher.add');

$app->post('/admin/publisher/postadd', $namespace.'\PublisherController:postAdd');

$app->post('/admin/publisher/softdelete', $namespace.'\PublisherController:softDelete');

$app->post('/admin/publisher/delete', $namespace.'\PublisherController:hardDelete')
        ->setName('publisher.delete');

$app->post('/admin/publisher/restore', $namespace.'\PublisherController:restore')
        ->setName('publisher.restore');

$app->get('/admin/publisher/update/{id}', $namespace.'\PublisherController:getUpdate')
        ->setName('publisher.update');

$app->post('/admin/publisher/postupdate/{id}', $namespace.'\PublisherController:postUpdate')
        ->setName('publisher.postupdate');
// -----------------------------------------------------------------------------
