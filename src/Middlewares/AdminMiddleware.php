<?php 

namespace MBS\Middlewares;

class AdminMiddleware extends BaseMiddleware
{
	public function __invoke($request, $response, $next)
	{
		if (!isset($_SESSION['admin'])) {
			//store current page 
			$_SESSION['url'] = (string) $request->getUri();

			$_SESSION['errors'][] = 'You must Login to access that page';

			return $response->withRedirect($this->container->router->pathFor('admin.login'));
		 } 

		$response = $next($request, $response);

		unset($_SESSION['url']);

		return $response;
	}
}