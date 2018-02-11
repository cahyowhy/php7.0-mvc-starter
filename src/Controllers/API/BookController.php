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
use Bookstore\Model\Book;
use Bookstore\Repository\BookRepository;

class BookController extends AbstractController
{
    /**
     * @return string
     * @throws InvalidIdException
     * @throws \Bookstore\Exceptions\DbException
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
            throw new InvalidIdException('some val are empty');

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

        if (empty($bookId))
            throw new InvalidIdException('result is error');

        return json_encode($bookResult->jsonSerialize());
    }
}