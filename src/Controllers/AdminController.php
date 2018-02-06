<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/5/18
 * Time: 3:45 PM
 */

namespace Bookstore\Controllers;


use Bookstore\Exceptions\InvalidIdException;
use Bookstore\Model\Admin;
use Bookstore\Repository\AdminRepository;
use Bookstore\Repository\BookRepository;
use Bookstore\Utils\JWT;

class AdminController extends AbstractController
{
    public function doLogin(): string
    {
        $properties = [];
        return $this->render('admin/login.twig', $properties);
    }

    public function doRegister(): string
    {
        $properties = [];
        return $this->render('admin/register.twig', $properties);
    }

    public function create(): string
    {
        header('Content-type: application/json');

        $adminBody = json_decode($this->request->getBody(), true);
        $username = $adminBody['username'];
        $password = $adminBody['password'];

        if (empty($username) || empty($password)) {
            throw new InvalidIdException('some val are empty');
        }

        $admin = new Admin();
        $admin->setPassword($password);
        $admin->setUsername($username);

        $adminRepository = new AdminRepository($this->db);
        $token = $adminRepository->create($admin);

        return json_encode($token);
    }

    public function validate(): string
    {
        header('Content-type: application/json');

        $adminBody = json_decode($this->request->getBody(), true);
        $username = $adminBody['username'];
        $password = $adminBody['password'];

        if (empty($username) || empty($password)) {
            throw new InvalidIdException('some val are empty');
        }

        $admin = new Admin();
        $admin->setPassword($password);
        $admin->setUsername($username);

        $adminRepository = new AdminRepository($this->db);
        $token = $adminRepository->validate($admin);

        return json_encode($token);
    }
}