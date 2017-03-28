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
		$this->basket->refresh();
		
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

	public function update(Request $request, Response $response, $args)
	{
		$book = new \MBS\Models\Book($this->db);

		$findBook = $book->find('slug', $args['slug']);

		if (!$findBook) {
			return $response->withRedirect($this->router->pathFor('home'));
		}
		if ($request->getParam('update') == 0) {
			$this->basket->remove($findBook);
		} else {
			if ($request->getParam('update') == 1 || $request->getParam('update') == -1) {
				$this->basket->add($findBook, $request->getParam('update'));
			} else {
				$this->flash->addMessage('errors', 'You can\'t Do That');
			}
			
		}

		return $response->withRedirect($this->router->pathFor('cart.index'));
	}
}