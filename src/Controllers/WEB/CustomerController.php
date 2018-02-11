<?php

namespace Bookstore\Controllers\WEB;


use Bookstore\Controllers\AbstractController;

class CustomerController extends AbstractController
{
    /**
     * @return string
     */
    public function doLogin(): string
    {
        $properties = [];
        return $this->render('customer/login.twig', $properties);
    }

    /**
     * @return string
     */
    public function doRegister(): string
    {
        $properties = [];
        return $this->render('customer/register.twig', $properties);
    }
}