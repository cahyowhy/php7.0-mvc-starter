<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/11/18
 * Time: 3:32 PM
 */

namespace Bookstore\Controllers\API;

use Bookstore\Exceptions\ParamEmptyException;
use Bookstore\Model\Admin;
use Bookstore\Repository\AdminRepository;
use Bookstore\Controllers\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @return string
     * @throws ParamEmptyException
     * @throws \Bookstore\Exceptions\DbException
     * @throws \Bookstore\Exceptions\InvalidIdException
     */
    public function create(): string
    {
        header('Content-type: application/json');

        $adminBody = json_decode($this->request->getBody(), true);
        $username = $adminBody['username'];
        $password = $adminBody['password'];

        if (empty($username) || empty($password))
            throw new ParamEmptyException();

        $admin = new Admin();
        $admin->setPassword($password);
        $admin->setUsername($username);

        $adminRepository = new AdminRepository($this->db);
        $token = $adminRepository->create($admin);

        return json_encode($token);
    }

    /**
     * @return string
     * @throws ParamEmptyException
     * @throws \Bookstore\Exceptions\NotFoundException
     */
    public function validate(): string
    {
        header('Content-type: application/json');

        $adminBody = json_decode($this->request->getBody(), true);
        $username = $adminBody['username'];
        $password = $adminBody['password'];

        if (empty($username) || empty($password))
            throw new ParamEmptyException();

        $admin = new Admin();
        $admin->setPassword($password);
        $admin->setUsername($username);

        $adminRepository = new AdminRepository($this->db);
        $token = $adminRepository->validate($admin);

        return json_encode($token);
    }
}