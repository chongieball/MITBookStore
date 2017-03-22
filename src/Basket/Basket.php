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

	public function add(Book $book, $qty)
	{
		if ($this->has($book)) {
			$qty = $this->get($book)['qty'] + $qty;
		}

		$this->update($book, $qty);
	}

	public function update(Book $book,$qty)
	{
		// if ($this->book->find('id', $book['id'])['stock'] === 0) {
			
		// }

		if ($qty === 0) {
			$this->remove($book);
			return;
		}

		$this->storage->set($book['id'], [
			'book_id'	=> (int) $book['id'],
			'qty'		=> (int) $qty,
		]);
	}

	public function remove(Book $book)
	{
		$this->storage->unset($book['id']);
	}

	public function has(Book $book)
	{
		return $this->storage->get($book);
	}

	public function get(Book $book)
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

		$books = $this->book->find($ids);

		foreach ($books as $book) {
			$book->qty = $this->get($product)['qty'];
			$items[] = $product;
		}

		return $items;
	}

	public function itemCount()
	{
		return count($this->storage);
	}
}