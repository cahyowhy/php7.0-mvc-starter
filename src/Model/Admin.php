<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/6/18
 * Time: 5:16 PM
 */

namespace Bookstore\Model;


class Admin
{
    private $id = 0;
    private $username = '';
    private $password = '';

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}