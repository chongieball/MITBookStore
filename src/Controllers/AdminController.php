<?php

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\Admin;

class AdminController extends BaseController
{

	public function index(Request $request, Response $response)
	{
		return $this->view->render($response, 'back-end/admin/home.twig');
	}

	public function getSignIn(Request $request, Response $response)
	{
		if (!empty($_SESSION['admin'])) {
			return $response->withRedirect($this->router->pathFor('admin.index'));
		}

		return $this->view->render($response, 'back-end/admin/login.twig');
	}

	public function postSignIn(Request $request, Response $response)
	{
		$admin    = new Admin($this->db);
		$username = $request->getParam('username');
		$password = $request->getParam('password');
		$check 	  = $admin->find('username', $username);
		$verify   = password_verify($password, $check['password']);

		if (!$verify) {
			$_SESSION['errors'][] = 'Username/Password is Wrong';

			return $response->withRedirect($this->router->pathFor('admin.signin'));
		}

		$_SESSION['admin'] = $check;

		return $response->withRedirect($_SESSION['url']);
	}

	public function getChangePassword(Request $request, Response $response)
	{
		return $this->view->render($response, 'back-end/admin/changepassword.twig');
	}

	public function postChangePassword()
	{
		$admin    = new Admin($this->db);
		$data     = $_SESSION['admin'];
		$id	      = $_SESSION['admin']['id'];
		$password = $_SESSION['admin']['password'];

		$verify   = password_verify($request->getParam('password_old'), $password);

		if (!$verify) {
                    $_SESSION['errors'][] = 'Your Old Password is Wrong';
			
		    return $response->witRedirect($this->router->pathFor('admin.change.password'));

		} else {
		    $admin->setPassword($request->getParam('password'), $id);
		}
        
            return $response->withRedirect($this->router->pathFor('admin.home'));
	}

	public function Logout(Request $request,Response $response)
	{
		unset($_SESSION['admin']);
		return $response->withRedirect($this->router->pathFor('admin.login'));
	}
}
