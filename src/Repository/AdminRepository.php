<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/6/18
 * Time: 6:52 PM
 */

namespace Bookstore\Repository;


use Bookstore\Exceptions\InvalidIdException;
use Bookstore\Model\Admin;
use Bookstore\Utils\JWT;
use PDO;

class AdminRepository extends BaseRepository
{
    const CLASSNAME = '\Bookstore\Model\Admin';

    public static function genereateToken(Admin $admin): array
    {
        $tokenParam = ['username' => $admin->getUsername(),
            'password' => $admin->getPassword()];

        return ['token' => JWT::encode($tokenParam, $_ENV['JWT_KEY'])];
    }

    public function create(Admin $admin): array
    {
        $query = 'INSERT INTO admin (username, password) VALUES (:username, :password)';
        $username = $admin->getUsername();
        $admin->setPassword(JWT::encode($admin->getPassword(), $_ENV['JWT_KEY']));
        $password = $admin->getPassword();

        $sth = $this->db->prepare($query);
        $sth->bindValue('username', $username);
        $sth->bindValue('password', $password);

        if (!$sth->execute()) {
            $this->db->rollBack();
            throw new DbException($sth->errorInfo()[2]);
        }

        $id = $this->db->lastInsertId();
        if (empty($id))
            throw new InvalidIdException('id empty');

        return self::genereateToken($admin);
    }


    public function validate(Admin $admin): array
    {
        $admin = $this->find($admin);
        if (empty($admin) && !is_array($admin))
            throw new InvalidIdException('username or password wrong');

        $admin = $admin[0];
        return self::genereateToken($admin);
    }

    public function find(Admin $admin): array
    {
        $query = 'SELECT * FROM admin ';
        $id = $admin->getId();
        $username = $admin->getUsername();
        $password = $admin->getPassword();

        if (!empty($id)) {
            $query = $query . 'WHERE admin.id = :id';
            $rows = $this->db->prepare($query);
            $rows->bindParam('id', $id);
            $rows->execute();

            return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        } else if (!empty($username) && !empty($password)) {
            $query = $query . 'WHERE admin.username = :username AND admin.password = :password';
            $rows = $this->db->prepare($query);
            $rows->bindParam('username', $username);
            $rows->bindParam('password', JWT::encode($password, $_ENV['JWT_KEY']));
            $rows->execute();

            return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        } else {
            return [];
        }
    }
}