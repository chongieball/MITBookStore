<?php 

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\Cart;
use MBS\Models\Book;

class CartController extends BaseController
{
	protected $basket; 

	public function __construct(Container $container,Basket $basket)
	{
		parent::__construct($container);
		$this->basket = $basket;
	}
	public function index(Request $request, Response $response)
	{
		return $this->view->render($response, 'front-end/cart/index.twig');
	}

	// public function add(Request $request, Response $response)
	// {
	// 	$book = new Book($this->db);
	// 	$findBook = $book->find('id', $request->getParam('cart'));
	// 	$oldCart = $_SESSION['cart'] ? $_SESSION['cart'] : null;
	// 	$cart = new Cart($oldCart);
	// 	$cart->add($findBook, $findBook['id']);

	// 	$_SESSION['cart'] = $cart;
	// 	var_dump($_SESSION['cart']);
	// 	// return $this->index($request, $response);
	// }
	
	public function add(Request $request, Response $response)
	{
		
	}
}