<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 2/12/18
 * Time: 3:36 PM
 */

namespace Bookstore\Utils;


class RedisKeyFormat
{
    public static function getCustomerRedisToken($email): string
    {
        return 'customer_token_' . $email;
    }

    public static function getAdminRedisToken($username): string
    {
        return 'admin_token_' . $username;
    }
}