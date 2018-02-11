<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/11/18
 * Time: 3:46 PM
 */

namespace Bookstore\Exceptions;

use Exception;

class ParamEmptyException extends Exception
{
    public function __construct($message = null)
    {
        $message = $message ?: 'some value still empty or missing?';
        parent::__construct($message);
    }
}