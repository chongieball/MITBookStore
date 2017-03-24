<?php

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\AuthorBook;
use MBS\Models\Author;
use MBS\Models\Book;

class AuthorBookController extends BaseController
{

    public function getAdd(Request $request, Response $response, $args)
    {

        $author = new \MBS\Models\Author($this->db);
        $authors = $author->allJoin(0);
        $data = array(
            'id' => $args['id'],
            'table' => $authors
        );
        // var_dump($data);
        return $this->view->render($response, 'back-end/book/add.author.twig', $data);
    }

    public function postAdd(Request $request, Response $response, $args)
    {
      $this->validator->rule('required', ['author_id'])
          ->message('{field} Must Not Empty');

      if ($this->validator->validate()) {

          $authorBook = new \MBS\Models\AuthorBook($this->db);
          $authorBook->add($request->getParams(), $args['id']);
          $this->flash->addMessage('success', 'Add Data Success');

      } else {
          $_SESSION['errors'] = $this->validator->errors();
          $_SESSION['old'] = $request->getParams();
          return $response->withRedirect($this->router
              ->pathFor('book.add.author' ,['id' => $args['id']]));
      }

        return $response->withRedirect($this->router
          ->pathFor('book.detail', ['id' => $args['id']]));
    }

}
