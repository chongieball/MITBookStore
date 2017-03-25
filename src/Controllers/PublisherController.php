<?php

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\Publisher;

class PublisherController extends BaseController
{
    public function index(Request $request, Response $response)
    {
        $publisher= new \MBS\Models\Publisher($this->db);
        $data['table'] = $publisher->getAll();
        return $this->view->render($response, 'back-end/publisher/index.twig', $data);
    }

    public function arsip(Request $request, Response $response)
    {
        $publisher= new \MBS\Models\Publisher($this->db);
        $data['table'] = $publisher->getArchive();
        return $this->view->render($response, 'back-end/publisher/arsip.twig', $data);
    }

    public function getAdd(Request $request, Response $response)
    {
        return $this->view->render($response, 'back-end/publisher/add.twig');
    }

    public function postAdd(Request $request, Response $response)
    {
        $this->validator->rule('required', ['name'])->message('{field} Must Not Empty');

        if ($this->validator->validate()) {
            $name['name'] = $request->getParam('name');
            $publisher = new \MBS\Models\Publisher($this->db);
            $publisher->create($name);
            $this->flash->addMessage('success', 'Add Data Success');

        } else {
            $_SESSION['errors'] = $this->validator->errors();
            $_SESSION['old'] = $request->getParams();
            return $response->withRedirect($this->router->pathFor('publisher.add'));
        }

        return $response->withRedirect($this->router
          ->pathFor('publisher.index'));
    }

    public function getUpdate(Request $request, Response $response, $args)
    {
        $publisher = new \MBS\Models\Publisher($this->db);
        $data['table'] = $publisher->findNotDelete('id', $args['id']);
        return $this->view->render($response, 'back-end/publisher/update.twig', $data);
    }

    public function postUpdate(Request $request, Response $response, $args)
    {
        $this->validator->rule('required',['name']);

        if ($this->validator->validate()) {
            $name['name'] = $request->getParam('name');
            $publisher = new \MBS\Models\Publisher($this->db);

            $publisher->update($name,'id', $args['id']);

            $this->flash->addMessage('success', 'Edit Data Success');

        } else {

            $_SESSION['errors'] = $this->validator->errors();

            $_SESSION['old'] = $request->getParams();

            return $response->withRedirect($this->router
                ->pathFor('publisher.update', ['id' => $args['id']]));
        }

        return $response->withRedirect($this->router
                  ->pathFor('publisher.index'));
    }

    public function softDelete(Request $request, Response $response)
    {

        $publisher = new \MBS\Models\Publisher($this->db);

        $find = $publisher->findNotDelete('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $publisher->softDelete('id', $request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['name'].' has been deleted');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('publisher.index'));
    }

    public function hardDelete(Request $request, Response $response)
    {

        $publisher = new \MBS\Models\Publisher($this->db);

        $find = $publisher->findNotDelete('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $publisher->delete($request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['name'].' has been deleted permanent');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('publisher.arsip'));
    }

    public function restore(Request $request, Response $response, $args)
    {

        $publisher = new \MBS\Models\Publisher($this->db);

        $find = $publisher->find('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $publisher->restore($request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['name'].' has been restored');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('publisher.arsip'));
    }
}
