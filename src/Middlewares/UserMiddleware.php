<?php 

namespace MBS\Middlewares;

use MBS\Models\User;

class UserMiddleware extends BaseMiddleware
{
	public function __invoke($request, $response, $next)
	{
		if (!isset($_SESSION['user'])) {
			//store current page 
			$_SESSION['url'] = (string) $request->getUri();

			$_SESSION['errors'][] = 'You must Login to access that page';

			return $response->withRedirect($this->container->router->pathFor('user.login'));
		 } //else {
		// 	if (!empty($_SESSION['user'])) {
		// 		$user = new User($this->container->db);
		// 		$find = $user->find('id', $_SESSION['user']['id']);
		// 		$_SESSION['user'] = $find;
		// 	}
		// }

		$response = $next($request, $response);

		if (!empty($_SESSION['user'])) {
				// $_SESSION['user'] = [];
				$user = new User($this->container->db);
				$find = $_SESSION['user'];
				$_SESSION['user'] = $user->find('id', $_SESSION['user']['id']);
			}
		unset($_SESSION['url']);

		return $response;
	}
}