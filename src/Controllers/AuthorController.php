<?php

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\Author;

class AuthorController extends BaseController
{

    public function index(Request $request, Response $response)
    {
        $author = new \MBS\Models\Author($this->db);
        $data['table'] = $author->allJoin(0);
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

            $author = new \MBS\Models\Author($this->db);
            $author->create($request->getParams());
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
        return $this->view->render($response, 'back-end/author/update.twig', $data);
    }

    public function postUpdate(Request $request, Response $response, $args)
    {
        $this->validator->rule('required',['name'])
            ->message('{field} Must Not Empty');

        if ($this->validator->validate()) {

            $author = new \MBS\Models\Author($this->db);

            $author->update($request->getParams(),'id', $args['id']);

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

        $find = $author->findNotDelete('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $author->restore($request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['name'].' has been restored');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('author.arsip'));
    }
}
