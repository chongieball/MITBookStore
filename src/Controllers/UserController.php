<?php 

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\User;

class UserController extends BaseController
{

	public function getRegister(Request $request, Response $response)
	{
		return $this->view->render($response, 'front-end/user/register.twig');
	}

	public function postRegister(Request $request, Response $response)
	{
		$rules = [
			'required'	=> [
				['username'],
				['email'],
				['password'],
				['confirmpassword'],
			],
			'alphaNum'	=> [
				['username'],
			],
			'email'	=> [
				['email'],
			],
			'lengthMin'	=> [
				['password', 6],
				['confirmpassword', 6]
			],
			'equals'	=> [
				['password', 'confirmpassword'],
			],
		];

		$this->validator->rules($rules);

		$this->validator->labels([
			'username'			=> 'Username',
			'password'			=> 'Password',
			'email'				=> 'Email',
			'confirmpassword'	=> 'Repeat Password'
			]);

		//validate 
		if ($this->validator->validate()) {
			$user = new User($this->db);

			$register = $user->checkDuplicate($request->getParam('username'), $request->getParam('email'));

			if ($register == 1) {
				$_SESSION['errors'][] = 'Username telah digunakan';
				return $response->withRedirect($this->router->pathFor('user.register'));
			} elseif ($register == 2) {
				$_SESSION['errors'][] = 'Email telah digunakan';
				return $response->withRedirect($this->router->pathFor('user.register'));
			} else {
				$user->register($request->getParams());
			}

		} else {
			$_SESSION['notice'] = $this->validator->errors();

			//when get error return old input
			$_SESSION['old'] = $request->getParams();


			foreach ($_SESSION['notice'] as $value) {
				$_SESSION['errors'] = $value;

			}

			return $response->withRedirect($this->router->pathFor('user.register'));

		}

		return $response->withRedirect($this->router->pathFor('user.login'));
	}

	public function getLogin(Request $request, Response $response)
	{
		unset($_SESSION['user']);
		return $this->view->render($response, 'front-end/user/login.twig');
	}

	public function postLogin(Request $request, Response $response)
	{
		$user = new User($this->db);

		$login = $user->find('username', $request->getParam('username'));

		if(empty($login)) {
			$_SESSION['errors'][] = 'Username is not Registered';
			return $response->withRedirect($this->router->pathFor('user.login'));
		} else {
			if (password_verify($request->getParam('password'), $login['password'])) {
				$_SESSION['user'] = $login;
				return $response->withRedirect($this->router->pathFor('home'));
			} else {
				$_SESSION['errors'][] = 'Wrong Password';
				return $response->withRedirect($this->router->pathFor('user.login'));
			}
		}

	}

	public function getProfile(Request $request, Response $response)
	{
		$user = new User($this->db);

		$data['data'] = $user->find('id', $_SESSION['user']['id']);

		return $this->view->render($response, 'user/profile', $data);
	}
}