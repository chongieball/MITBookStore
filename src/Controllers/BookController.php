<?php

namespace MBS\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MBS\Models\Book;
use MBS\Models\Publisher;
use MBS\Models\AuthorBook;
use MBS\Models\Author;
use MBS\Models\CategoryBook;
use MBS\Models\Category;

class BookController extends BaseController
{

    public function index(Request $request, Response $response)
    {
        $book = new \MBS\Models\Book($this->db);
        $data['table'] = $book->allJoin(0);
        return $this->view->render($response, 'back-end/book/index.twig', $data);
    }

    public function arsip(Request $request, Response $response)
    {
        $book = new \MBS\Models\Book($this->db);
        $data['table'] = $book->allJoin(1);
        return $this->view->render($response, 'back-end/book/arsip.twig', $data);
    }

    public function detail(Request $request, Response $response, $args)
    {

        $authorBook = new \MBS\Models\AuthorBook($this->db);
        $authorBooks = $authorBook->findAuthor('book_id', $args['id']);
        $author = new \MBS\Models\Author($this->db);
        foreach ($authorBooks as $val) {
            $authors = $author->find('id', $val['author_id']);
            $name_author[] = $authors['name'];
        }
        $data['author'] = $name_author;

        // $categoryBook = new \MBS\Models\CategoryBook($this->db);
        // $categoryBooks = $categoryBook->findCategory('book_id', $args['id']);
        // $category = new \MBS\Models\Category($this->db);
        // foreach ($categoryBooks as $vale) {
        //     $categorys = $category->find('id', $vale['category_id']);
        //     $name_category[] = $categorys['name'];
        // }
        // $data['category'] = $name_category;
        $book = new \MBS\Models\Book($this->db);
        $data['table'] = $book->allDetail($args['id']);

        // $book = new \MBS\Models\Book($this->db);
        // $data = $book->coba($args['id']);
        // foreach ($data as $key => $value) {
        //     $data[$key] = $value['author'];
        // }
                // var_dump($data);
                // $data['table'] = $book->allDetail($args['id']);

        return $this->view->render($response, 'back-end/book/detail.twig', $data);
    }

    public function getAdd(Request $request, Response $response)
    {

        $publisher= new \MBS\Models\Publisher($this->db);
        $data['table'] = $publisher->allJoin(0);
        return $this->view->render($response, 'back-end/book/add.twig', $data);
    }

    public function postAdd(Request $request, Response $response)
    {

        $storage = new \Upload\Storage\FileSystem('assets/images');
        $file = new \Upload\File('images', $storage);

        $new_filename = uniqid();
        $file->setName($new_filename);

        $file->addValidations(array(

            new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
            'image/jpg', 'image/jpeg')),

            new \Upload\Validation\Size('5M')
        ));

        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        );

        $this->validator->rule('required', ['publisher_id', 'isbn', 'title',
            'description', 'publish_year', 'total_page', 'synopsis',
            'price', 'stock'])->message('{field} Must Not Empty');

        if ($this->validator->validate()) {

            $book = new \MBS\Models\Book($this->db);
            if ($file->upload()) {
                $book->add($request->getParams(), $data['name']);
                $this->flash->addMessage('success', 'Add Data Success');
            } else {

                $errors = $file->getErrors();
                $error = print_r($errors);
                $_SESSION['errors'] = $this->validator->errors();

                $_SESSION['old'] = $request->getParams();

                $this->flash->addMessage('errors', $error);

                return $response->withRedirect($this->router
                    ->pathFor('book.add'));
            }

        } else {

            $_SESSION['errors'] = $this->validator->errors();

            $_SESSION['old'] = $request->getParams();

            return $response->withRedirect($this->router
                ->pathFor('book.add'));
        }

        return $response->withRedirect($this->router
        ->pathFor('book.index'));
    }

    public function getUpdate(Request $request, Response $response, $args)
    {
        $book = new \MBS\Models\Book($this->db);
        $data['table'] = $book->find('id', $args['id']);

        return $this->view->render($response, 'back-end/book/update.twig', $data);
    }

    public function postUpdate(Request $request, Response $response, $args)
    {
        $this->validator->rule('required', ['publisher_id', 'isbn', 'title',
            'description', 'publish_year', 'total_page', 'synopsis',
            'price', 'stock'])->message('{field} Must Not Empty');

        if ($this->validator->validate()) {

            $book = new \MBS\Models\Book($this->db);

            $book->update($request->getParams(),'id', $args['id']);

            $this->flash->addMessage('success', 'Edit Data Success');

        } else {

            $_SESSION['errors'] = $this->validator->errors();

            $_SESSION['old'] = $request->getParams();

            return $response->withRedirect($this->router
                ->pathFor('book.update', ['id' => $args['id']]));
        }

        return $response->withRedirect($this->router
                  ->pathFor('book.index'));
    }

    public function getChange(Request $request, Response $response, $args)
    {
        $book = new \MBS\Models\Book($this->db);
        $data['table'] = $book->find('id', $args['id']);
        return $this->view->render($response, 'back-end/book/change.twig', $data);
    }

    public function postChange(Request $request, Response $response, $args)
    {
        $storage = new \Upload\Storage\FileSystem('assets/images');
        $file = new \Upload\File('images', $storage);

        $new_filename = uniqid();
        $file->setName($new_filename);

        $file->addValidations(array(

            new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
            'image/jpg', 'image/jpeg')),

            new \Upload\Validation\Size('5M')
        ));

        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        );

        if ($this->validator->validate()) {

            $book = new \MBS\Models\Book($this->db);
            if ($file->upload()) {
                $book->changeImage($data['name'],'id', $args['id']);
                $this->flash->addMessage('success', 'Add Data Success');

            } else {

                $errors = $file->getErrors();
                $error = print_r($errors);
                $_SESSION['errors'] = $this->validator->errors();

                $_SESSION['old'] = $request->getParams();

                $this->flash->addMessage('errors', $error);

                return $response->withRedirect($this->router
                    ->pathFor('book.chage'));
            }

        } else {

            $_SESSION['errors'] = $this->validator->errors();

            $_SESSION['old'] = $request->getParams();

            return $response->withRedirect($this->router
                ->pathFor('book.change'));
        }

        return $response->withRedirect($this->router
        ->pathFor('book.index'));
    }

    public function softDelete(Request $request, Response $response)
    {

        $book = new \MBS\Models\Book($this->db);

        $find = $book->find('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $book->softDelete('id', $request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['title'].' has been deleted');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('book.index'));
    }

    public function hardDelete(Request $request, Response $response)
    {

        $book = new \MBS\Models\Book($this->db);

        $find = $book->find('id', $request->getParam('id'));
        $_SESSION['delete'] = $find;

        $delete = $book->delete($request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['delete']['title'].' has been deleted permanent');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('book.arsip'));
    }

    public function restore(Request $request, Response $response)
    {

        $book = new \MBS\Models\Book($this->db);

        $find = $book->find('id', $request->getParam('id'));
        $_SESSION['restore'] = $find;

        $delete = $book->restore($request->getParam('id'));

        $this->flash->addMessage('info', $_SESSION['restore']['title'].' has been restored');
        unset($_SESSION['delete']);

        return $response->withRedirect($this->router
                  ->pathFor('book.arsip'));
    }
}
