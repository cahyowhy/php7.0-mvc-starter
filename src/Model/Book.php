<?php

namespace Bookstore\Model;

class Book
{
    private $id = 0;
    private $isbn = '';
    private $title = '';
    private $author = '';
    private $stock = 0;
    private $price = 0.0;
    private $customers = [];

    public function getCustomers(): array
    {
        return $this->customers;
    }

    public function setCustomers(array $customers)
    {
        $this->customers = $customers;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    /*public function getCopy(): bool {
        if ($this->stock < 1) {
            return false;
        } else {
            $this->stock--;
            return true;
        }
    }

    public function addCopy() {
        $this->stock++;
    }*/

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }
}
