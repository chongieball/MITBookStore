<?php 

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\Book;

class OrderController extends BaseController
{

	public function index(Request $request, Response $response)
	{
		$this->basket->refresh();

		if (!$this->basket->all()) {
			return $response->withRedirect($this->router->pathFor('cart.index'));
		}

		$orderId = $_SESSION['order']['id'];

		$order = new \MBS\Models\Order($this->db);
		$data['order'] = $order->show($orderId);

		return $this->view->render($response, 'front-end/order/index.twig', $data);
	}

	public function order(Request $request, Response $response)
	{
		if (!isset($_SESSION['user'])) {
			$_SESSION['url'] = $this->router->pathFor('cart.index');

			return $response->withRedirect($this->router->pathFor('user.login'));
		}
		$order = new \MBS\Models\Order($this->db);
		$addOrder['user_id'] = $_SESSION['user']['id'];

		$orderId = $order->add($addOrder);

		$orderItem = new \MBS\Models\OrderItem($this->db);

		foreach ($this->basket->all() as $value) {
			$data[] = [
				'order_id'	=> $orderId,
				'book_id'	=> $value['id'],
				'qty'		=> $value['qty'],
			];
		}
		//get order ID
		$_SESSION['order']['id'] = $orderId;

		$orderItem->add($data);

		return $this->index($request, $response);
	}
}