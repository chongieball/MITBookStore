<?php

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthorController extends BaseController
{

    public function index(Request $request, Response $response)
    {
        $author = new \MBS\Models\Author($this->db);
        $data['table'] = $author->getAll();
        return $this->view->render($response, 'back-end/author/index.twig', $data);
    }

    public function arsip(Request $request, Response $response)
    {
        $author = new \MBS\Models\Author($this->db);
        $data['table'] = $author->allJoin(1);
        return $this->view->render($response, 'back-end/author/arsip.twig', $data);
    }

    public function getAdd(Request $request, Response $response)
    {
        return $this->view->render($response, 'back-end/author/add.twig');
    }

    public function postAdd(Request $request, Response $response)
    {
        $this->validator->rule('required',['name'])
        ->message('{field} Must Not Empty');

        if ($this->validator->validate()) {
            $name['name'] = $request->getParam('name');
            $author = new \MBS\Models\Author($this->db);
            $author->create($name);
            $this->flash->addMessage('success', 'Add Data Success');

        } else {
            $_SESSION['errors'] = $this->validator->errors();
            $_SESSION['old'] = $request->getParams();
            return $response->withRedirect($this->router
                ->pathFor('author.add'));
        }

        return $response->withRedirect($this->router->pathFor('author.index'));
    }

    public function getUpdate(Request $request, Response $response, $args)
    {
        $author = new \MBS\Models\Author($this->db);
        $data['table'] = $author->findNotDelete('id', $args['id']);
        if ($data['table']) {
            return $this->view->render($response, 'back-end/author/update.twig', $data);
        } else {
            return $response->withStatus(404);
        }
        
    }

    public function postUpdate(Request $request, Response $response, $args)
    {
        $this->validator->rule('required',['name'])
            ->message('{field} Must Not Empty');

        if ($this->validator->validate()) {
            $name['name'] = $request->getParam('name');
            $author = new \MBS\Models\Author($this->db);

            $author->update($name,'id', $args['id']);

            $this->flash->addMessage('success', 'Edit Data Success');

        } else {

            $_SESSION['errors'] = $this->validator->errors();

            $_SESSION['old'] = $request->getParams();

            return $response->withRedirect($this->router
                ->pathFor('author.update', ['id' => $args['id']]));
        }

        return $response->withRedirect($this->router
                  ->pathFor('author.index'));
    }

    public function softDelete(Request $request, Response $response)
    {

        $author = new \MBS\Models\Author($this->db);

        $find = $author->findNotDelete('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $author->softDelete('id', $request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['name'].' has been deleted');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('author.index'));
    }

    public function hardDelete(Request $request, Response $response)
    {

        $author = new \MBS\Models\Author($this->db);

        $find = $author->findNotDelete('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $author->delete($request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['name'].' has been deleted permanent');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('author.arsip'));
    }

    public function restore(Request $request, Response $response)
    {

        $author = new \MBS\Models\Author($this->db);

        $find = $author->find('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $author->restore($request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['name'].' has been restored');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('author.arsip'));
    }

    public function getAddAuthorInBook(Request $request, Response $response, $args)
    {

        $author = new \MBS\Models\Author($this->db);
        $authors = $author->getAll();
        $data = array(
            'id' => $args['id'],
            'table' => $authors
        );
        return $this->view->render($response, 'back-end/book/add.author.twig', $data);
    }

    public function postAddAuthorInBook(Request $request, Response $response, $args)
    {
      $this->validator->rule('required', ['author_id'])
          ->message('{field} Must Not Empty');

      if ($this->validator->validate()) {
          $author['author_id'] = $request->getParam('author_id');
          $authorBook = new \MBS\Models\AuthorBook($this->db);
          $authorBook->add($author, $args['id']);
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
