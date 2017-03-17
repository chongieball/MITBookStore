<?php 

namespace MBS\Models;

class User extends BaseModel
{
	protected $table = 'user';
	protected $column = ['id', 'username', 'email', 'password', 'name', 'phone', 'address', 'deleted'];

	public function register(array $data)
	{
			$data = [
			'username'	=> $data['username'],
			'password'	=> password_hash($data['password'], PASSWORD_BCRYPT),
			'email'		=> $data['email'],
			];
			$this->create($data);
	}

	public function checkDuplicate($username, $email)
	{
		$checkUsername = $this->find('username', $username);
		$checkEmail = $this->find('email', $email);

		if ($checkUsername) {
			return 1;
		} elseif ($checkEmail) {
			return 2;
		}

		return false;
	}

}