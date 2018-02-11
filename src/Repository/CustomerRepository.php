<?php

namespace Bookstore\Repository;

use Bookstore\Exceptions\DbException;
use Bookstore\Exceptions\InvalidIdException;
use Bookstore\Model\Customer;
use PDO;
use JWT;

class CustomerRepository extends BaseRepository
{
    const CLASSNAME = '\Bookstore\Model\Customer';
    use \GenerateToken;

    /**
     * @param Customer $customer
     * @return array
     * @throws DbException
     * @throws InvalidIdException
     */
    public function create(Customer $customer): array
    {
        $query = <<<SQL
        INSERT INTO customer (firstname, surname, email, type, password)
        VALUES (:firstname, :surname, :email, :type, :password)
SQL;

        $firstname = $customer->getFirstname();
        $surname = $customer->getSurname();
        $email = $customer->getEmail();
        $type = $customer->getType();

        $customer->setPassword(JWT::encode($customer->getPassword(), $_ENV['JWT_KEY']));
        $password = $customer->getPassword();

        $sth = $this->db->prepare($query);
        $sth->bindValue('firstname', $firstname);
        $sth->bindValue('surname', $surname);
        $sth->bindValue('email', $email);
        $sth->bindValue('type', $type);
        $sth->bindValue('password', $password);

        if (!$sth->execute()) {
            $this->db->rollBack();
            throw new DbException($sth->errorInfo()[2]);
        }

        $id = $this->db->lastInsertId();
        if (empty($id))
            throw new InvalidIdException('id empty');

        return self::generateToken(true, null, $customer);
    }

    public function find(Customer $customer): array
    {
        $query = 'SELECT * FROM customer ';
        $id = $customer->getId();
        $email = $customer->getEmail();
        $password = $customer->getPassword();

        if (!empty($id)) {
            $query = $query . 'WHERE customer.id = :id';
            $rows = $this->db->prepare($query);
            $rows->bindParam('id', $id);
            $rows->execute();

            return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        } else if (!empty($email) && !empty($password)) {
            $query = $query . 'WHERE customer.email = :email AND customer.password = :password';
            $rows = $this->db->prepare($query);
            $rows->bindParam('email', $email);
            $rows->bindParam('password', JWT::encode($password, $_ENV['JWT_KEY']));
            $rows->execute();

            return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        } else {
            return [];
        }
    }
}