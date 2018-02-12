<?php

namespace Bookstore\Utils;

use Bookstore\Model\Admin;
use Bookstore\Model\Customer;

trait GenerateToken
{
    /**
     * GenerateToken constructor.
     * @param bool $isCustomer
     * @param Admin $admin
     * @param Customer $customer
     *
     * @return array
     */
    public function generateToken($isCustomer = true, Admin $admin = null, Customer $customer = null): array
    {
        $tokenParam = [];
        if ($isCustomer) {
            $tokenParam['email'] = $customer->getEmail();
            $tokenParam['password'] = $customer->getPassword();
            $tokenParam['hasRole'] = 'CUSTOMER';
        } else {
            $tokenParam['username'] = $admin->getUsername();
            $tokenParam['password'] = $admin->getPassword();
            $tokenParam['hasRole'] = 'ADMIN ';
        }

        return ['token' => JWT::encode($tokenParam, $_ENV['JWT_KEY'])];
    }
}