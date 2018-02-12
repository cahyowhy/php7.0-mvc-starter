<?php

namespace Bookstore\Repository;


use Bookstore\Model\BookBorrow;

class BookBorrowRepository extends BaseRepository
{
    const CLASSNAME = '\Bookstore\Model\BookBorrow';

    public function create(BookBorrow $bookBorrow): int
    {
        $query = <<<SQL
        INSERT INTO borrowed_books (`book_id`, `customer_id`, `start`, `end`)
        VALUES (:bookId, :customerId, :startVal, :endVal)
SQL;

        $sth = $this->db->prepare($query);

        $sth->bindValue('bookId', $bookBorrow->getBookId());
        $sth->bindValue('customerId', $bookBorrow->getCustomerId());
        $sth->bindValue('startVal', $bookBorrow->getStart());
        $sth->bindValue('endVal', $bookBorrow->getEnd());

        if (!$sth->execute()) {
            $this->db->rollBack();
            throw new DbException($sth->errorInfo()[2]);
        }

        return $this->db->lastInsertId();
    }
}