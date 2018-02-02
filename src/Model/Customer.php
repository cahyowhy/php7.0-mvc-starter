<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/2/18
 * Time: 7:59 PM
 */

namespace Bookstore\Model;


class Customer
{
    private $id;
    private $firstname;
    private $surname;
    private $email;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}