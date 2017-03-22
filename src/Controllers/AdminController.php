<?php

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\Admin;

class AdminController extends BaseController
{



	public function index(Request $request, Response $response)
	{
		return $this->view->render($response, 'admin/home.twig');
	}


	public function getSignIn()
	{
		return $this->view->render($response, 'admin/signin.twig');
	}

	public function postSignIn()
	{
		$admin    = new Admin($this->db);
		$email    = $request->getParam('email');
		$password = $request->getParam('password');
		$check 	  = $admin->find('email', $email);
		$verify   = password_verify($password, $check['password']);

		if (!$verify) {
			return $response->withRedirect($this->router->pathFor('admin.signin'));
		}


		$_SESSION['admin'] = $check;
		return $response->withRedirect($this->router->pathFor('admin.home'));
	}

	public function getChangePassword()
	{
		return $this->view->render($response, 'admin/changepassword.twig');

	}

	public function postChangePassword()
	{
		$admin    = new Admin($this->db);
		$data     = $_SESSION['admin'];
		$id	      = $_SESSION['admin']['id'];
		$password = $_SESSION['admin']['password'];

		$verify   = password_verify($request->getParam('password_old'), $password);

		if (!$verify) {

			return $response->witRedirect($this->router->pathFor('admin.change.password'));

		} else {
			$admin->setPassword($request->getParam('password'), $id);
			return $response->withRedirect($this->router->pathFor('admin.home'));
		}
	}

	public function signOut()
	{
		unset($_SESSION['admin']);
	}


}
