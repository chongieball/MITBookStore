<?php 

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class InvoiceController extends BaseController
{
	public function index(Request $request, Response $response)
	{
		$invoice = new \MBS\Models\Invoice($this->db);
		var_dump($invoice->showAll());
	}

	public function add(Request $request, Response $response)
	{
		$date = date('YmdH');
		$data = [
			'order_id'		=> $_SESSION['order']['id'],
			'code'			=> $_SESSION['user']['id']. $date,
			'total_price'	=> $this->basket->subTotal() + substr($date, -2),
		];
		$invoice = new \MBS\Models\Invoice($this->db);
		$invoice->create($data);
		
		return $this->index($request, $response);
	}
}