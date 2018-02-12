<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/12/18
 * Time: 4:56 PM
 */

namespace Bookstore\Model;


class BookBorrow
{
    private $id = '0';
    private $book_id = '0';
    private $customer_id = '0';
    private $start = '0';
    private $end = '0';

    public function getBookId(): string
    {
        return $this->book_id;
    }

    public function setBookId(string $book_id)
    {
        $this->book_id = $book_id;
    }

    public function getCustomerId(): string
    {
        return $this->customer_id;
    }

    public function setCustomerId(string $customer_id)
    {
        $this->customer_id = $customer_id;
    }

    public function getStart(): string
    {
        return $this->start;
    }

    public function setStart(string $start)
    {
        $this->start = $start;
    }

    public function getEnd(): string
    {
        return $this->end;
    }

    public function setEnd(string $end)
    {
        $this->end = $end;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }
}