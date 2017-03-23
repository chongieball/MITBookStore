<?php

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\Category;

class CategoryController extends BaseController
{
    public function index(Request $request, Response $response)
    {
        $category = new \MBS\Models\Category($this->db);
        $data['table'] = $category->allJoin(0);
        return $this->view->render($response, 'back-end/category/index.twig', $data);
    }

    public function arsip(Request $request, Response $response)
    {
        $category = new \MBS\Models\Category($this->db);
        $data['table'] = $category->allJoin(1);
        return $this->view->render($response, 'back-end/category/arsip.twig', $data);
    }

    public function getAdd(Request $request, Response $response)
    {
        return $this->view->render($response, 'back-end/category/add.twig');
    }

    public function postAdd(Request $request, Response $response)
    {
      $this->validator->rule('required', ['name'])
          ->message('{field} Must Not Empty');

      if ($this->validator->validate()) {

          $category = new \MBS\Models\Category($this->db);
          $category->create($request->getParams());
          $this->flash->addMessage('success', 'Add Data Success');

      } else {
          $_SESSION['errors'] = $this->validator->errors();
          $_SESSION['old'] = $request->getParams();
          return $response->withRedirect($this->router
              ->pathFor('category.add'));
      }

        return $response->withRedirect($this->router
          ->pathFor('category.index'));
    }

    public function getUpdate(Request $request, Response $response, $args)
    {
        $category = new \MBS\Models\Category($this->db);
        $data['table'] = $category->find('id', $args['id']);
        return $this->view->render($response, 'back-end/category/update.twig', $data);
    }

    public function postUpdate(Request $request, Response $response, $args)
    {
        $this->validator->rule('required',['name'])
            ->message('{field} Must Not Empty');

        if ($this->validator->validate()) {

            $category = new \MBS\Models\Category($this->db);

            $category->update($request->getParams(),'id', $args['id']);

            $this->flash->addMessage('success', 'Edit Data Success');

        } else {

            $_SESSION['errors'] = $this->validator->errors();

            $_SESSION['old'] = $request->getParams();

            return $response->withRedirect($this->router
                ->pathFor('category.update', ['id' => $args['id']]));
        }

        return $response->withRedirect($this->router
                  ->pathFor('category.index'));
    }

    public function softDelete(Request $request, Response $response)
    {

        $category = new \MBS\Models\Category($this->db);

        $find = $category->find('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $category->softDelete('id', $request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['name'].' has been deleted');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('category.index'));
    }

    public function hardDelete(Request $request, Response $response)
    {

        $category = new \MBS\Models\Category($this->db);

        $find = $category->find('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $category->delete($request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['name'].' has been deleted permanent');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('category.arsip'));
    }

    public function restore(Request $request, Response $response, $args)
    {

        $category = new \MBS\Models\Category($this->db);

        $find = $category->find('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $category->restore($request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['name'].' has been restored');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('category.arsip'));
    }
}
