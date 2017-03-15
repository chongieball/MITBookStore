<?php 

$namespace = 'MBS\Controllers';

$app->get('/admin', $namespace.'\AdminController:index')->setName('admin.index');
