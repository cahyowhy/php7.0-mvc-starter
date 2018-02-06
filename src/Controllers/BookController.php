<?php

namespace Bookstore\Controllers;


use Bookstore\Exceptions\InvalidIdException;
use Bookstore\Model\Book;
use Bookstore\Model\Customer;
use Bookstore\Repository\BookRepository;

class BookController extends AbstractController
{
    public function show(int $bookId): string
    {
        $bookParam = new Book();
        $bookParam->setId($bookId);
        $bookRepository = new BookRepository($this->db);
        $book = $bookRepository->find($bookParam);

        if (empty($book)) $this->renderErr();

        $bookProperty = $book[0];
        if (!empty($bookProperty->cust_id)) {
            $customers = [];
            foreach ($book as $key => $value) {
                $customer = new Customer();
                $customer->setId($value->cust_id);
                $customer->setFirstname($value->cust_name);
                $customer->setEmail($value->cust_email);

                array_push($customers, $customer);
            }

            $bookProperty->setCustomers($customers);
        }

        $properties = ['book' => $bookProperty];
        return $this->render('book.twig', $properties);
    }

    public function create()
    {
        header('Content-type: application/json');

        $bookBody = json_decode($this->request->getBody(), true);
        $title = $bookBody['title'];
        $author = $bookBody['author'];
        $price = $bookBody['price'];
        $stock = $bookBody['stock'];
        $isbn = $bookBody['isbn'];

        if (empty($title) || empty($author) || empty($price) || empty($stock) || empty($isbn)) {
            throw new InvalidIdException('some val are empty');
        }

        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setPrice($price);
        $book->setStock($stock);
        $book->setIsbn($isbn);

        $bookRepository = new BookRepository($this->db);
        $bookId = $bookRepository->create($book);
        if (empty($bookId))
            $this->renderErr();

        $book->setId($bookId);
        $bookResult = $bookRepository->find($book);
        $bookResult = $bookResult[0];

        if (empty($bookId)) {
            throw new InvalidIdException('result is error');
            return json_encode(["message" => "result empty"]);
        }

        return json_encode($bookResult->jsonSerialize());
    }

    public function search(): string
    {
        $isbn = $this->request->getParams()->getString('isbn');
        $title = $this->request->getParams()->getString('title');
        $author = $this->request->getParams()->getString('author');

        $bookParam = new Book();
        $bookParam->setIsbn($isbn);
        $bookParam->setTitle($title);
        $bookParam->setAuthor($author);

        $bookRepository = new BookRepository($this->db);
        $book = $bookRepository->find($bookParam);

        if (empty($book)) $this->renderErr();

        $properties = [
            'books' => $book,
            'title' => 'result',
            'description' => 'result for search'
        ];
        return $this->render('search.twig', $properties);
    }

    private function renderErr()
    {
        $properties = ['errorMessage' => '404'];
        return $this->render('error.twig', $properties);
    }
}