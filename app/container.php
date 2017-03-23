<?php

use Slim\Container;
use Slim\Views\Twig as View;
use Slim\Views\TwigExtension as ViewExt;

$container = $app->getContainer();

$container['db'] = function (Container $container) {
	$setting = $container->get('settings');

	$config = new \Doctrine\DBAL\Configuration();

	$connect = \Doctrine\DBAL\DriverManager::getConnection($setting['db'],
		$config);

	// return $connect;

	return $connect->createQueryBuilder();
};

$container['view'] = function (Container $container) {
	$setting = $container->get('settings')['view'];

	$view = new View($setting['path'], $setting['twig']);
	$view->addExtension(new ViewExt($container->router, $container->request->getUri()));

	$view->getEnvironment()->addGlobal('flash', $container->flash);

	if ($_SESSION['old']) {
		$view->getEnvironment()->addGlobal('old', $_SESSION['old']);
		unset($_SESSION['old']);
	}

	if ($_SESSION['errors']) {
		$view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
		unset($_SESSION['errors']);
	}

	if ($_SESSION['user']) {
		$view->getEnvironment()->addGlobal('user', $_SESSION['user']);
	}

if (isset($_SESSION['old'])) {
	$view->getEnvironment()->addGlobal('old', $_SESSION['old']);
	unset($_SESSION['old']);
}

if (isset($_SESSION['errors'])) {
	$view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
	unset($_SESSION['errors']);
}
	return $view;
};

$container['validator'] = function (Container $container) {
	$setting = $container->get('settings')['lang']['default'];
	$params = $container['request']->getParams();

	return new Valitron\Validator($params, [], $setting);
};

$container['flash'] = function (Container $container) {
	return new \Slim\Flash\Messages;
};
