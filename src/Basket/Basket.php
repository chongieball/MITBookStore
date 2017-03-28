<?php 

namespace MBS\Basket;

use MBS\Models\Book;
use MBS\Core\Storage\SessionStorage;

class Basket
{
	protected $storage;
	protected $book;

	public function __construct(SessionStorage $storage, Book $book)
	{
		$this->storage = $storage;
		$this->book = $book;
	}

	public function add($book, $qty = 1)
	{
		if ($this->has($book)) {
			$qty = $this->get($book)['qty'] + $qty;
		}
		$this->update($book, $qty);
	}

	public function update($book,$qty)
	{
		if ($qty == 0) {
			$this->remove($book);
			return;
		}

		$this->storage->set($book['id'], [
			'book_id'	=> (int) $book['id'],
			'qty'		=> (int) $qty,
		]);
	}

	public function remove($book)
	{
		$this->storage->unset($book['id']);
	}

	public function has($book)
	{
		return $this->storage->exists($book['id']);
	}

	public function get($book)
	{
		return $this->storage->get($book['id']);
	}

	public function clear()
	{
		$this->storage->clear();
	}

	public function all()
	{
		$ids = [];
		$items = [];
		$qty = [];

		foreach ($this->storage->all() as $book) {
			$ids[] = $book['book_id'];
			$qty[] = $book['qty'];
		}

		if (!empty($ids)) {
			$books = $this->book->getIdWhereIn($ids);

			foreach ($books as $book) {
				$book['qty'] = $this->get($book)['qty'];
				$items[] = $book;
			}
		}
		
		return $items;
	}

	public function itemCount()
	{
		return count($this->storage);
	}

	public function checkStock($id)
	{
		$findBook = $this->book->find('id', $id);
		return $this->get($findBook)['qty'] >= $findBook['stock'];
	}

	public function subTotal()
	{
		$total = 0;

		foreach ($this->all() as $item) {
			if ($item['stock'] === 0) {
				continue;
			}

			$total = $total + $item['price'] * $item['qty'];
		}
		return $total;
	}

	public function totalQty()
	{
		$total = 0;

		foreach ($this->all() as $item) {
			$total = $total + $item['qty'];
		}

		return $total;
	}

	public function refresh()
	{
		foreach ($this->all() as $value) {
			if ($value['stock'] <= $value['qty']) {
				$this->update($value, $value['stock']);
			}
		}
	}
}