<?php 

namespace MBS\Core\Storage;

use MBS\Core\Storage\Contracts\StorageInterface;
use Countable;

class SessionStorage implements StorageInterface, Countable
{
	protected $bucket = 'cart';

	public function __construct($bucket = null)
	{
		if (!isset($_SESSION[$bucket])) {
			$_SESSION[$bucket] = [];
		}

		$this->bucket = $bucket;
	}

	public function set($index, $value)
	{
		$_SESSION[$this->bucket][$index] = $value;
	}

	public function get($index)
	{
		if (!isset($_SESSION[$this->bucket][$index])) {
			return null;
		}

		return $_SESSION[$this->bucket][$index];
	}

	public function all()
	{
		return $_SESSION[$this->bucket];
	}

	public function unset($index)
	{
		if (isset($_SESSION[$this->bucket][$index]))
		{
			unset($_SESSION[$this->bucket][$index]);
		}
	}

	public function clear()
	{
		unset($_SESSION[$this->bucket]);
	}

	public function count()
	{
		return count($this->all());
	}

}