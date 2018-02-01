<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 01/02/18
 * Time: 21:32
 */

namespace Bookstore\Repository;

use PDO;

class BaseRepository
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}