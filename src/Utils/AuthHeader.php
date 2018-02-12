<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/12/18
 * Time: 4:31 PM
 */

namespace Bookstore\Utils;

use Exception;

trait AuthHeader
{
    public function authHeader($token, $log): array
    {
        $decodedToken = null;
        try {
            $decodedToken = JWT::decode($token, $_ENV['JWT_KEY']);
        } catch (Exception $e) {
            $log->error($e->getMessage());
        }

        return (array)$decodedToken;
    }
}