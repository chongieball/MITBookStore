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
				$_SESSION['errors'][] = 'Username is Taken';
				return $response->withRedirect($this->router->pathFor('user.register'));
			} elseif ($register == 2) {
				$_SESSION['errors'][] = 'Email is Taken';
				return $response->withRedirect($this->router->pathFor('user.register'));
			} else {
				$register = $request->getParams();
				$this->delCsrfPost($register);
				$user->register($register);

				$this->flash->addMessage('success', 'Register Success!');
			}

		} else {
			$notice = array_reverse($this->validator->errors());

			//when get error return old input
			$_SESSION['old'] = $request->getParams();


			foreach ($notice as $value) {
				$_SESSION['errors'] = $value;

			}

			return $response->withRedirect($this->router->pathFor('user.register'));

		}

		return $response->withRedirect($this->router->pathFor('user.login'));
	}

	public function getLogin(Request $request, Response $response)
	{
		if (empty($_SESSION['user'])) {
			return $this->view->render($response, 'front-end/user/login.twig');
		} else {
			return $response->withRedirect($this->router->pathFor('home'));
		}
		
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

			} else {
				$_SESSION['errors'][] = 'Wrong Password';
				return $response->withRedirect($this->router->pathFor('user.login'));
			}
		}
		//redirect to current page
		return $response->withRedirect($_SESSION['url']);

	}

	public function getLogout(Request $request, Response $response)
	{
		unset($_SESSION['user']);
		return $response->withRedirect($this->router->pathFor('user.login'));
	}

	public function getAccount(Request $request, Response $response)
	{
		return $this->view->render($response, 'front-end/user/profile.twig');
	}

	public function getEdit(Request $request, Response $response)
	{
		if ($request->getQueryParam('section') == 'shipping_address') {
			return $this->view->render($response, 'front-end/user/edit_shipping_address.twig');
		} elseif ($request->getQueryParam('section') == 'change_password') {
			return $this->view->render($response, 'front-end/user/edit_password.twig');
		} elseif ($request->getQueryParam('section') == 'general') {
			return $this->view->render($response, 'front-end/user/edit_general.twig');
		}
		return $response->withStatus(404);
	}

	public function postEdit(Request $request, Response $response)
	{
		$user = new User($this->db);

		if ($request->getQueryParam('section') == 'shipping_address') {
			$rules = [
				'required'	=> [
					['name'],
					['phone'],
					['address'],
				],
				'numeric'	=> [
					['phone'],
				],
			];

			$this->validator->rules($rules);

			$this->validator->labels([
				'name'			=> 'Name',
				'phone'			=> 'Phone',
				'address'		=> 'Address',
				]);

			//validate 
			if ($this->validator->validate()) {
				$post = $this->delCsrfPost($request->getParsedBody());

				$user->update($post, 'id', $_SESSION['user']['id']);

			} else {
				$_SESSION['errors'] = $this->validator->errors();

				//when get error return old input
				$_SESSION['old'] = $request->getParsedBody();

				return $response->withRedirect($this->router->pathFor('user.edit')."?section=shipping_address");
			}
		} elseif ($request->getQueryParam('section') == 'change_password') {
			$rules = [
				'required'	=> [
					['old_password'],
					['new_password'],
					['repeat_password'],
				],
				'equals'	=> [
					['new_password', 'repeat_password'],
				],
			];

			$this->validator->rules($rules);

			$this->validator->labels([
				'old_password'		=> 'Old Password',
				'new_password'		=> 'New Password',
				'repeat_password'	=> 'Repeat Password',
			]);

			//validate 
			if ($this->validator->validate()) {
				if (password_verify($request->getParam('old_password'), $_SESSION['user']['password'])) {
					$password['password'] = $request->getParam('new_password');

					$user->changePassword($password, 'id', $_SESSION['user']['id']);
					
				} else {
					$_SESSION['errors']['old_password'][] = 'Old Password is Wrong';

					return $response->withRedirect($this->router->pathFor('user.edit')."?section=change_password");
				}
				
			} else {
				$_SESSION['errors'] = $this->validator->errors();

				//when get error return old input
				$_SESSION['old'] = $request->getParsedBody();

				return $response->withRedirect($this->router->pathFor('user.edit')."?section=change_password");
			}
		} elseif ($request->getQueryParam('section') == 'general') {
			$rules = [ 
				'email' => ['required', 'email'],
			];
			$this->validator->mapFieldsRules($rules);

			if ($this->validator->validate()) {
				$email['email'] = $request->getParam('email');

				$user->update($email, 'id', $_SESSION['user']['id']);
			} else {
				$_SESSION['errors'] = $this->validator->errors();

				//when get error return old input
				$_SESSION['old'] = $request->getParsedBody();

				return $response->withRedirect($this->router->pathFor('user.edit')."?section=change_password");
			}
		}
		$this->flash->addMessage('success', 'Your Account Has Been Update');

		return $response->withRedirect($this->router->pathFor('user.account'));
	}

	public function getResetPassword(Request $request, Response $response)
	{
		return $this->view->render($response, 'front-end/user/reset_password.twig');
	}

	public function postResetPassword(Request $request, Response $response)
	{
		$this->validator->rule('required', ['email', 'username']);
		$this->validator->rule('email', 'email');

		if ($this->validator->validate()) {
			$user = new User($this->db);

			$reset = $user->find('username', $request->getParam('username'));
			if ($reset) {
				if ($reset['email'] !== $request->getParam('email')) {
					$_SESSION['errors']['email'][] = 'Email is Wrong';
				} else {
					$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    				$password = substr( str_shuffle( $chars ), 0, 6 );

    				$resetPass['password'] = password_hash($password, PASSWORD_BCRYPT);

    				// $user->update($resetPass, 'username', $request->getParam('username'));
    				$this->flash->addMessage('success', 'Your Password is '. "<b>$password</b>. Please <a href='./login'>Login</a>");
				}
			} else {
				$_SESSION['errors']['username'][] = 'Username is Wrong';
			}
		} else {
			$_SESSION['errors'] = $this->validator->errors();

		}

		return $response->withRedirect($this->router->pathFor('user.reset_password'));
	}

}