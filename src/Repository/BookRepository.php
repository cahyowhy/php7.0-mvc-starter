<?php

namespace Bookstore\Repository;

use Bookstore\Model\Book;
use PDO;

class BookRepository extends BaseRepository
{
    const CLASSNAME = '\Bookstore\Model\Book';

    public function index(int $offset, int $limit): array
    {
        $query = 'SELECT * FROM book LIMIT :offset, :limit';

        $rows = $this->db->prepare($query);
        $rows->bindParam('offset', $offset, PDO::PARAM_INT);
        $rows->bindParam('limit', $limit, PDO::PARAM_INT);
        $rows->execute();

        return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function find(Book $book): array
    {
        $query = 'SELECT * FROM book ';
        $id = !empty($book->getId());
        $isbn = !empty($book->getIsbn());

        if ($id || $isbn) {
            // https://stackoverflow.com/questions/5673269/what-is-the-advantage-of-using-heredoc-in-php
            $query = 'SELECT book.*,
customer.id AS cust_id,
customer.firstname AS cust_name,
customer.email AS cust_email
FROM book
LEFT JOIN borrowed_books
ON book.id = borrowed_books.book_id
LEFT JOIN customer
ON customer.id = borrowed_books.customer_id ';
        }

        if ($id) {
            $query = $query . 'WHERE book.id = :id';
            $rows = $this->db->prepare($query);
            $rows->bindParam('id', $book->getId());
            $rows->execute();

            return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        } else if ($isbn) {
            $query = $query . 'WHERE isbn = :isbn';

            $rows = $this->db->prepare($query);
            $rows->bindParam('id', $book->getId());
            $rows->execute();

            return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        } else {
            $author = !empty($book->getAuthor());
            $title = !empty($book->getTitle());
            if ($author || $title) {
                $query = $query . ' WHERE 1=1 ';
                if ($author)
                    $query = $query . 'AND author LIKE :author ';

                if ($title)
                    $query = $query . 'AND title LIKE :title ';

                $rows = $this->db->prepare($query);

                if ($author) {
                    $param = '%' . $book->getAuthor() . '% ';
                    $rows->bindParam('author', $param);
                }

                if ($title) {
                    $param = '%' . $book->getTitle() . '% ';
                    $rows->bindParam('title', $param);
                }

                $rows->execute();
                return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
            }

            return [];
        }
    }

    public function count(): int
    {
        $query = 'SELECT count(*) as total from book';
        $rows = $this->db->prepare($query);
        $rows->execute();
        $results = $rows->fetch(PDO::FETCH_ASSOC);

        return $results['total'];
    }
}