<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/11/18
 * Time: 3:36 PM
 */

namespace Bookstore\Controllers\API;

use Bookstore\Controllers\AbstractController;
use Bookstore\Exceptions\InvalidIdException;
use Bookstore\Exceptions\ParamEmptyException;
use Bookstore\Exceptions\UnauthorizeException;
use Bookstore\Model\Book;
use Bookstore\Model\BookBorrow;
use Bookstore\Repository\BookBorrowRepository;
use Bookstore\Repository\BookRepository;

class BookController extends AbstractController
{
    /**
     * @return string
     * @throws InvalidIdException
     * @throws \Bookstore\Exceptions\DbException
     * @throws ParamEmptyException
     */
    public function create()
    {
        header('Content-type: application/json');

        $bookBody = json_decode($this->request->getBody(), true);
        $title = $bookBody['title'];
        $author = $bookBody['author'];
        $price = $bookBody['price'];
        $stock = $bookBody['stock'];
        $isbn = $bookBody['isbn'];

        if (empty($title) || empty($author) || empty($price) || empty($stock) || empty($isbn))
            throw new ParamEmptyException('some val are empty');

        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setPrice($price);
        $book->setStock($stock);
        $book->setIsbn($isbn);

        $bookRepository = new BookRepository($this->db);
        $bookId = $bookRepository->create($book);
        if (empty($bookId))
            throw new InvalidIdException('book not saved');

        $book->setId($bookId);
        $bookResult = $bookRepository->find($book);
        $bookResult = $bookResult[0];

        return json_encode($bookResult->jsonSerialize());
    }

    /**
     * @return string
     * @throws InvalidIdException
     * @throws ParamEmptyException
     */
    public function borrow(): string
    {
        header('Content-type: application/json');
        try {
            $this->validateAuthHeader();
        } catch (UnauthorizeException $e) {
            $this->log->error($e->getMessage());
        }

        $bookBorrowBody = json_decode($this->request->getBody(), true);
        $bookId = $bookBorrowBody['book_id'];
        $customerId = $bookBorrowBody['customer_id'];
        $start = $bookBorrowBody['start'];
        $end = $bookBorrowBody['end'];

        if (empty($bookId) || empty($customerId) || empty($start) || empty($end))
            throw new ParamEmptyException('some val are empty');

        $bookBorrow = new BookBorrow();
        $bookBorrow->setBookId($bookId);
        $bookBorrow->setCustomerId($customerId);
        $bookBorrow->setStart($start);
        $bookBorrow->setEnd($end);

        $bookBorrowRepository = new BookBorrowRepository($this->db);
        $bookBorrowedId = $bookBorrowRepository->create($bookBorrow);
        if (empty($bookBorrowedId))
            throw new InvalidIdException('book borrowed not saved');

        $book = new Book();
        $book->setId($bookBorrowedId);
        $bookRepository = new BookRepository($this->db);

        $bookResult = $bookRepository->find($book);
        $bookResult = $bookResult[0];

        return json_encode($bookResult->jsonSerialize());
    }
}