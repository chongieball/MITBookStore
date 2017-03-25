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
        $data['table'] = $category->getAll();
        return $this->view->render($response, 'back-end/category/index.twig', $data);
    }

    public function arsip(Request $request, Response $response)
    {
        $category = new \MBS\Models\Category($this->db);
        $data['table'] = $category->getArchive();
        return $this->view->render($response, 'back-end/category/arsip.twig', $data);
    }

    public function getAdd(Request $request, Response $response)
    {
        return $this->view->render($response, 'back-end/category/add.twig');
    }

    public function postAdd(Request $request, Response $response)
    {
        $this->validator->rule('required', ['name'])->message('{field} Must Not Empty');

        if ($this->validator->validate()) {
            $name['name'] = $request->getParam('name');
            $category = new \MBS\Models\Category($this->db);
            $category->create($name);
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
        $data['table'] = $category->findNotDelete('id', $args['id']);
        return $this->view->render($response, 'back-end/category/update.twig', $data);
    }

    public function postUpdate(Request $request, Response $response, $args)
    {
        $this->validator->rule('required',['name']);
        if ($this->validator->validate()) {
            $name['name'] = $request->getParam('name');
            $category = new \MBS\Models\Category($this->db);

            $category->update($name,'id', $args['id']);

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

        $find = $category->findNotDelete('id', $request->getParam('id'));
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

        $find = $category->findNotDelete('id', $request->getParam('id'));
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

    public function getAddCategoryInBook(Request $request, Response $response, $args)
    {

        $category = new \MBS\Models\Category($this->db);
        $categorys = $category->getAll();
        $data = array(
            'id' => $args['id'],
            'table' => $categorys
        );
        return $this->view->render($response, 'back-end/book/add.category.twig', $data);
    }

    public function postAddCategoryInBook(Request $request, Response $response, $args)
    {
        $this->validator->rule('required', ['category_id']);

        if ($this->validator->validate()) {
            $category['category_id'] = $request->getParam('category_id');
            $categoryBook = new \MBS\Models\CategoryBook($this->db);
            $categoryBook->add($category, $args['id']);
            $this->flash->addMessage('success', 'Add Data Success');

      } else {
          $_SESSION['errors'] = $this->validator->errors();
          $_SESSION['old'] = $request->getParams();
          return $response->withRedirect($this->router
              ->pathFor('book.add.category' ,['id' => $args['id']]));
      }

        return $response->withRedirect($this->router
          ->pathFor('book.detail', ['id' => $args['id']]));
    }

}
