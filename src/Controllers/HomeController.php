<?php 

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\Book;

class HomeController extends BaseController
{

	public function index(Request $request, Response $response)
	{
		$book = new Book($this->db);
		$data['book'] = $book->getAll();
		// unset($_SESSION['cart']);
		$category = new \MBS\Models\Category($this->db);
		$data['category'] = $category->getAll();
		
		return $this->view->render($response, 'front-end/home.twig', $data);
	}
}