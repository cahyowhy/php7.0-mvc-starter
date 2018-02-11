<?php

namespace Bookstore\Controllers\WEB;

use Bookstore\Controllers\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @return string
     */
    public function doLogin(): string
    {
        $properties = [];
        return $this->render('admin/login.twig', $properties);
    }

    /**
     * @return string
     */
    public function doRegister(): string
    {
        $properties = [];
        return $this->render('admin/register.twig', $properties);
    }
}