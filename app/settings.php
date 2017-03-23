<?php

return [
	//setting display error
	'displayErrorDetails'	=> true,

	'addContentLengthHeader' => false,

	//setting timezone
	'timezone'	=> 'Asia/Jakarta',

	//setting language
	'lang'	=> [
		'default'	=> 'en',
	],

	//setting db (with doctrine)
	'db'	=> [
		'url'	=> 'mysql://root:root@localhost/book_store_dev_db',
	],

	//setting view (using twig)
	'view'	=> [
		'path'	=> '../views',
		'twig'	=> [
			'cache'	=> false,
			],
	],
];
