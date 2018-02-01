<?php

namespace Bookstore\Repository;

use PDO;

class BookRepository extends BaseRepository
{
    const CLASSNAME = '\Bookstore\Model\Book';

    public function index(int $offset, int $limit): array
    {
        $query = 'SELECT * FROM book LIMIT :offset, :limit';

        $rows = $this->db->prepare($query);
        $rows->bindParam('offset', $offset, PDO::PARAM_INT);
        $rows->bindParam('limit', $limit, PDO::PARAM_INT);
        $rows->execute();

        return $rows->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function count(): int
    {
        $query = 'SELECT count(*) as total from book';
        $rows = $this->db->prepare($query);
        $rows->execute();
        $results = $rows->fetch(PDO::FETCH_ASSOC);

        return $results['total'];
    }
}