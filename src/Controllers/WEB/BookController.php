<?php

namespace Bookstore\Controllers\WEB;

use Bookstore\Controllers\AbstractController;
use Bookstore\Model\Book;
use Bookstore\Model\Customer;
use Bookstore\Repository\BookRepository;

class BookController extends AbstractController
{
    /**
     * @param int $bookId
     * @return string
     */
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

                array_push($customers, $customer->jsonSerialize());
            }

            $bookProperty->setCustomers($customers);
        }

        $properties = ['book' => json_encode($bookProperty->jsonSerialize()), 'id' => $bookId];

        return $this->render('book/book.twig', $properties);
    }

    /**
     * @return string
     */
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
        return $this->render('book/book-search.twig', $properties);
    }

    /**
     * @return string
     */
    private function renderErr()
    {
        $properties = ['errorMessage' => '404'];
        return $this->render('error.twig', $properties);
    }
}