<?php

namespace Bookstore\Controllers;


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

        if (empty($book)) {
            $properties = ['errorMessage' => '404'];
            return $this->render('error.twig', $properties);
        }

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
}