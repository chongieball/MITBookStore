<?php

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\CategoryBook;
use MBS\Models\Category;

class CategoryBookController extends BaseController
{

    public function getAdd(Request $request, Response $response, $args)
    {

        $category = new \MBS\Models\Category($this->db);
        $categorys = $category->allJoin(0);
        $data = array(
            'id' => $args['id'],
            'table' => $categorys
        );
        // var_dump($data);
        return $this->view->render($response, 'back-end/book/add.category.twig', $data);
    }

    public function postAdd(Request $request, Response $response, $args)
    {
      $this->validator->rule('required', ['category_id'])
          ->message('{field} Must Not Empty');

      if ($this->validator->validate()) {

          $categoryBook = new \MBS\Models\CategoryBook($this->db);
          $categoryBook->add($request->getParams(), $args['id']);
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
