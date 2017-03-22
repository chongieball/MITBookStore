<?php 

namespace MBS\Models;

class Cart
{
	public $book = null;
	public $totalQty = 0;
	public $totalPrice = 0;

	public function __construct($oldCart)
	{
		if ($oldCart) {
			$this->book = $oldCart->book;
			$this->totalQty = $oldCart->totalQty;
			$this->totalPrice = $oldCart->totalPrice;
		}
	}

	public function add($book, $id)
	{
		$storedItem = ['qty' => 0, 'price' => $book['price'], 'book' => $book];
		if ($this->book) {
			if (array_key_exists($id, $this->book)) {
				$storedItem[] = $this->book[$id];
			}
		}
		$storedItem['qty']++;
		$storedItem['price'] = $book['price'] * $storedItem['qty'];
		$this->book[$id] = $storedItem;
		$this->totalQty++;
		$this->totalPrice += $book['price'];
	}
}