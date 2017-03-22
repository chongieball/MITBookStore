<?php 

namespace MBS\Middlewares;

class ShippingMiddleware extends BaseMiddleware
{
	public function __invoke($request, $response, $next)
	{
		//when column 'name','phone','address' in user table is null
		if (!isset($_SESSION['user']) && !($_SESSION['user']['name'] && $_SESSION['user']['phone'] && $_SESSION['user']['address'])) {
			$this->container->flash->addMessage('info', 'Your Shipping Address is Empty, Please Fill the Form');

			return $response->withRedirect($this->container->router->pathFor('user.edit').'?section=shipping_address');
		}

		$response = $next($request, $response);

		return $response;
	}
}