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
		 } //else {
		// 	if (!empty($_SESSION['user'])) {
		// 		$user = new User($this->container->db);
		// 		$find = $user->find('id', $_SESSION['user']['id']);
		// 		$_SESSION['user'] = $find;
		// 	}
		// }

		$response = $next($request, $response);

		unset($_SESSION['url']);

		return $response;
	}
}