<?php

namespace MBS\Controllers;

use Slim\Container;

abstract class BaseController
{
	protected $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function __get($property)
	{
		if ($this->container->{$property}) {
			return $this->container->{$property};
		}
	}

	//for delete CSRF value
	public function delCsrfPost($post)
	{
		for ($i=0; $i < 2; $i++) { 
			array_pop($post);
		}

		return $post;
	}
}
