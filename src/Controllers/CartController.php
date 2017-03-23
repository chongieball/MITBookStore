<?php 

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\Book;
use MBS\Basket\Basket;

class CartController extends BaseController
{ 
	public function index(Request $request, Response $response)
	{
		return $this->view->render($response, 'front-end/cart/index.twig');
	}
	
	public function add(Request $request, Response $response)
	{
		$book = new Book($this->db);
		$findBook = $book->find('id', $request->getParam('cart'));

		if (!findBook) {
			return $response->withRedirect($this->router->pathFor('home'));
		}

		$this->basket->add($findBook);

		return $response->withRedirect($this->router->pathFor('cart.index'));
	}
}