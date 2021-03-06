<?php

namespace Bookstore\Repository;

use Bookstore\Exceptions\DbException;
use Bookstore\Model\Book;
use PDO;

class BookRepository extends BaseRepository
{
    const CLASSNAME = '\Bookstore\Model\Book';

    /**
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function index(int $offset, int $limit): array
    {
        $query = 'SELECT * FROM book LIMIT :offset, :limit';

        $rows = $this->db->prepare($query);
        $rows->bindParam('offset', $offset, PDO::PARAM_INT);
        $rows->bindParam('limit', $limit, PDO::PARAM_INT);
        $rows->execute();

        return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    /**
     * @param Book $book
     * @return array
     */
    public function find(Book $book): array
    {
        $query = 'SELECT * FROM book ';
        $hasId = !empty($book->getId());
        $hasIsbn = !empty($book->getIsbn());

        if ($hasId || $hasIsbn) {
            // https://stackoverflow.com/questions/5673269/what-is-the-advantage-of-using-heredoc-in-php
            $query = <<<SQL
          SELECT book.*,
          customer.id AS cust_id,
          customer.firstname AS cust_name,
          customer.email AS cust_email
          FROM book
          LEFT JOIN borrowed_books
          ON book.id = borrowed_books.book_id
          LEFT JOIN customer
          ON customer.id = borrowed_books.customer_id 
SQL;
        }

        if ($hasId) {
            $query = $query . 'WHERE book.id = :id';
            $rows = $this->db->prepare($query);
            $rows->bindParam('id', $book->getId());
            $rows->execute();

            return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        } else if ($hasIsbn) {
            $query = $query . 'WHERE isbn = :isbn';

            $rows = $this->db->prepare($query);
            $rows->bindParam('isbn', $book->getIsbn());
            $rows->execute();

            return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        } else {
            $hasAuthor = !empty($book->getAuthor());
            $hasTitle = !empty($book->getTitle());
            if ($hasAuthor || $hasTitle) {
                $query = $query . 'WHERE 1=1 ';
                if ($hasAuthor)
                    $query = $query . 'AND author LIKE :author ';

                if ($hasTitle)
                    $query = $query . 'AND title LIKE :title ';

                $rows = $this->db->prepare($query);

                if ($hasAuthor) {
                    $param = "%" . $book->getAuthor() . "%";
                    $rows->bindParam('author', $param);
                }

                if ($hasTitle) {
                    $param = "%" . $book->getTitle() . "%";
                    $rows->bindParam('title', $param);
                }

                $rows->execute();
                return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
            }

            return [];
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $query = 'SELECT count(*) as total from book';
        $rows = $this->db->prepare($query);
        $rows->execute();
        $results = $rows->fetch(PDO::FETCH_ASSOC);

        return $results['total'];
    }

    /**
     * @param Book $book
     * @return int
     * @throws DbException
     */
    public function create(Book $book): int
    {
        $query = 'INSERT INTO book (title, isbn, author, stock, price)
        VALUES (:title, :isbn, :author, :stock, :price);';

        $sth = $this->db->prepare($query);

        // https://stackoverflow.com/questions/1179874/what-is-the-difference-between-bindparam-and-bindvalue
        $sth->bindValue('title', $book->getTitle());
        $sth->bindValue('author', $book->getAuthor());
        $sth->bindValue('price', $book->getPrice());
        $sth->bindValue('stock', $book->getStock());
        $sth->bindValue('isbn', $book->getIsbn());

        if (!$sth->execute()) {
            $this->db->rollBack();
            throw new DbException($sth->errorInfo()[2]);
        }

        return $this->db->lastInsertId();
    }
}