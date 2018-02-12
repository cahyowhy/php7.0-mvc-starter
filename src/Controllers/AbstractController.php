<?php
/**
 * Created by PhpStorm.
 * User: cahyo
 * Date: 01/02/18
 * Time: 20:52
 */

namespace Bookstore\Controllers;


use Bookstore\Core\Request;
use Bookstore\Exceptions\UnauthorizeException;
use Bookstore\Utils\AuthHeader;
use Bookstore\Utils\DependencyInjector;
use Bookstore\Utils\RedisKeyFormat;

abstract class AbstractController
{
    use AuthHeader;

    protected $request;
    protected $db;
    protected $config;
    protected $view;
    protected $log;
    protected $di;
    protected $redist;

    public function __construct(DependencyInjector $di, Request $request)
    {
        $this->request = $request;
        $this->di = $di;

        $this->db = $di->get('PDO');
        $this->log = $di->get('Logger');
        $this->view = $di->get('Twig_Environment');
        $this->config = $di->get('Utils\Config');
        $this->redist = $di->get('Redis');
    }

    protected function render(string $template, array $params): string
    {
        return $this->view->loadTemplate($template)->render($params);
    }

    /**
     * @param bool $isCustomer
     * @throws UnauthorizeException
     */
    protected function validateAuthHeader($isCustomer = true)
    {
        $token = $this->request->getHeaders('Authorization');
        if (empty($token))
            throw new UnauthorizeException();

        $decodedToken = self::authHeader($token, $this->log);

        //validate customer token & email
        $identifier = $isCustomer ? $decodedToken['email'] : $decodedToken['username'];
        $key = $isCustomer ? RedisKeyFormat::getCustomerRedisToken($identifier) : RedisKeyFormat::getAdminRedisToken($identifier);
        if (!$this->redist->exists($key) || $this->redist->hget($key, 'token') !== $token)
            throw new UnauthorizeException();
    }
}