<?php 

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class InvoiceController extends BaseController
{
	public function index(Request $request, Response $response)
	{
		$invoice = new \MBS\Models\Invoice($this->db);
		$data['invoice'] = $invoice->find('order_id', $_SESSION['order']['id']);
		$data['invoice']['unique'] = substr($data['invoice']['code'], -2);
		
		$order = new \MBS\Models\Order($this->db);
		$data['order'] = $order->show($_SESSION['order']['id']);

		unset($_SESSION['order']);
		unset($_SESSION['invoice']);

		$this->basket->clear();

		return $this->view->render($response, 'front-end/invoice/invoice.twig', $data);
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
		$_SESSION['invoice']['id'] = $invoice->add($data);

		$order = new \MBS\Models\Order($this->db);
		$showOrder = $order->show($_SESSION['order']['id']);

		foreach ($showOrder as $key => $value) {
			$book = new \MBS\Models\Book($this->db);
			$findBook = $book->find('id', $value['book_id']);
			$dataBook[] = $findBook;

			foreach ($dataBook as $key => $val) {
				$update['stock'] = $val['stock'] - $value['qty'];
				$book->update($update, 'id', $val['id']);
			}
		}
		
		return $this->index($request, $response);
	}

}