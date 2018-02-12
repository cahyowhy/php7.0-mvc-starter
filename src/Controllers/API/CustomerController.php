<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/11/18
 * Time: 6:53 PM
 */

namespace Bookstore\Controllers\API;


use Bookstore\Controllers\AbstractController;
use Bookstore\Exceptions\ParamEmptyException;
use Bookstore\Model\Customer;
use Bookstore\Repository\CustomerRepository;
use Bookstore\Utils\RedisKeyFormat;

class CustomerController extends AbstractController
{
    /**
     * @return string
     */
    public function showTypes(): string
    {
        header('content-type: application/json');

        $customerRepository = new CustomerRepository($this->db);
        $types = $customerRepository->showLabel();

        return json_encode($types);
    }

    /**
     * @return string
     * @throws ParamEmptyException
     * @throws \Bookstore\Exceptions\DbException
     * @throws \Bookstore\Exceptions\InvalidIdException
     */
    public function create(): string
    {
        header('content-type: application/json');

        $customerBody = json_decode($this->request->getBody(), true);
        $email = $customerBody['email'];
        $password = $customerBody['password'];
        $firstname = $customerBody['firstname'];
        $surname = $customerBody['surname'];
        $type = $customerBody['type'];

        $someValEmpty = empty($email) || empty($password) || empty($firstname) || empty($surname) || empty($type);

        if ($someValEmpty)
            throw new ParamEmptyException();

        $customer = new Customer();
        $customer->setEmail($email);
        $customer->setPassword($password);
        $customer->setFirstname($firstname);
        $customer->setSurname($surname);
        $customer->setType($type);

        $customerRepository = new CustomerRepository($this->db);
        $token = $customerRepository->create($customer);

        return json_encode($token);
    }

    /**
     * @return string
     * @throws ParamEmptyException
     */
    public function validate(): string
    {
        header('content-type: application/json');

        $customerBody = json_decode($this->request->getBody(), true);
        $email = $customerBody['email'];
        $password = $customerBody['password'];

        if (empty($email) || empty($password))
            throw new ParamEmptyException();

        $customer = new Customer();
        $customer->setEmail($email);
        $customer->setPassword($password);

        $customerRepository = new CustomerRepository($this->db);
        $token = $customerRepository->validate($customer);

        // store token, set expired 2hours after saved
        $key = RedisKeyFormat::getCustomerRedisToken($email);
        $this->redist->hset($key, 'email', $email);
        $this->redist->hset($key, 'token', $token['token']);
        $this->redist->expire($key, time() + 7200);

        $customer->setPassword('');
        $customerResult = $customerRepository->find($customer);
        $customerResult = $customerResult[0]->jsonSerialize();
        $customerResult['token'] = $token['token'];

        return json_encode($customerResult);
    }
}