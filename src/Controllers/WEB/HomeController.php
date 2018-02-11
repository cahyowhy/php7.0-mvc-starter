<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 01/02/18
 * Time: 21:08
 */

namespace Bookstore\Controllers\WEB;


use Bookstore\Controllers\AbstractController;
use Bookstore\Repository\BookRepository;

class HomeController extends AbstractController
{
    const PAGE_DEFAULT = 4;

    /**
     * @return string
     */
    public function index(): string
    {
        $offset = $this->request->getParams()->getInt('offset');
        $real_offset = 0;
        $current_page = 1;
        if (!isset($offset) || $offset < 2) $offset = 0;

        if ($offset > 1) $current_page = $offset;

        if (!empty($offset)) $real_offset = ($offset - 1) * self::PAGE_DEFAULT;

        $bookRepository = new BookRepository($this->db);
        $bookTotal = $bookRepository->count();
        $totalPage = 0;
        if (!empty($bookTotal)) $totalPage = round($bookTotal / self::PAGE_DEFAULT);

        $books = $bookRepository->index($real_offset, self::PAGE_DEFAULT);
        $pages = [];

        foreach (range(1, $totalPage) as $index) {
            array_push($pages, $index);
        }

        $properties = [
            'totalPage' => $totalPage,
            'currentPage' => $current_page,
            'offset' => $offset,
            'pages' => $pages,
            'title' => 'Book my love :*',
            'description' => 'all this books is deserve loves ma lady, total book now is ' . $bookTotal,
            'books' => $books
        ];

        return $this->render('index.twig', $properties);
    }
}