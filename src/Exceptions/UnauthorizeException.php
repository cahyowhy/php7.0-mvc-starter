<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/11/18
 * Time: 3:49 PM
 */

namespace Bookstore\Exceptions;

use Exception;

class UnauthorizeException extends Exception
{
    public function __construct($message = null)
    {
        $message = $message ?: 'failed to validate credential';
        parent::__construct($message);
    }
}