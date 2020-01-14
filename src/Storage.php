<?php

namespace Devscast;

/**
 * Class Storage
 * @package Devscast
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class Storage
{

    /**
     * Storage constructor.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            throw new \RuntimeException("The session must be started in order to use this type of storage");
        }
    }

    /**
     * @param string $key
     * @param $value
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @param string $key
     * @return bool
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
