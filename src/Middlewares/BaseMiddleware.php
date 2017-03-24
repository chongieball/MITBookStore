<?php 

namespace MBS\Middlewares;

use Slim\Container;

abstract class BaseMiddleware
{
	protected $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}
}