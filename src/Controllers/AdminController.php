<?php

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AdminController extends BaseController
{

	public function index(Request $request, Response $response)
	{
		return $this->view->render($response, 'admin/home.twig');
	}

	public function getSignUp(Request $request, Response $response) {
		return $this->view->render($response, 'admin/signup.twig');
	}

	public function postSignUp(Request $request, Response $response)
	{
		$admin = new Admin($this->db);

		$this->validation->rule('required', ['name', 'email', 'password']);

		if ($this->validation->validate()) {
			$admin->add($request->getParams());
			return $response->withRedirect($this->router->pathFor('admin.add'));
		} else {
			$_SESSION['errors'] = $this->validation->errors();
			$_SESSION['old'] = $request->getParams();

			return $response->withRedirect($this->router->pathFor('admin.add.post'))
		}
	}


}
