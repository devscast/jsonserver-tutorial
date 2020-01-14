<?php

namespace Devscast;

use Faker\Factory;
use Faker\Generator as FakerGenerator;

/**
 * Class Generator
 * @package Devscast
 * @author bernard-ng <ngandubernard@gmail.com>
 */
final class Generator
{
    /** @var FakerGenerator */
    private FakerGenerator $faker;

    /** @var array */
    private const DATA_TYPES = [
        "posts",
        "users",
        "post",
        "user"
    ];

    /**
     * Generator constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    /**
     * @param string $key
     * @return array|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getStorage(string $key): ?array
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @param string $key
     * @param array $data
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setStorage(string $key, array $data): void
    {
        $_SESSION[$key] = $data;
    }

    /**
     * Generate Posts and store in session
     *
     * @param integer $number
     * @return array
     */
    private function generatePosts(int $number = 100): array
    {
        if (!$this->getStorage('api_posts')) {
            $data = [];
            for ($i = 1; $i <= $number; $i++) {
                $data[] = $this->generatePost([$i], false);
            }
            $this->setStorage('api_posts', $data);
        }
        return $this->getStorage('api_posts');
    }

    /**
     * Generate Users and store in session
     *
     * @param integer $number
     * @return array
     */
    private function generateUsers(int $number = 100): array
    {
        if (!$this->getStorage('api_users')) {
            $data = [];
            for ($i = 1; $i <= $number; $i++) {
                $data[] = $this->generateUser([$i], false);
            }
            $this->setStorage('api_users', $data);
        }
        return $this->getStorage('api_users');
    }

    /**
     * Generate a user and store it by default
     *
     * @param array $params
     * @param boolean $useStorage
     * @return array
     */
    private function generateUser(array $params = [], bool $useStorage = true): array
    {
        [$id] = $params;
        $user = [
            'id' => $id,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => \uniqid('password_')
        ];
        return $this->getFromStorage("api_users_{$id}", $user, $useStorage);
    }

    /**
     * Generate a post and store it by default
     *
     * @param array $params
     * @param boolean $useStorage
     * @return array
     */
    private function generatePost(array $params = [], bool $useStorage = true): array
    {
        [$id] = $params;
        $post = [
            'id' => $id,
            'userId' => ($id % 10 == 0) ? 1 : $id % 10,
            'title' => $this->faker->words(3, true),
            'content' => $this->faker->sentences(3, true)
        ];
        return $this->getFromStorage("api_post_{$id}", $post, $useStorage);
    }

    /**
     * store data in session to simulate a database storage
     *
     * @param string $key
     * @param array $data
     * @param boolean $useStorage
     * @return array|null
     */
    private function getFromStorage(string $key, array $data, bool $useStorage): ?array
    {
        if ($useStorage) {
            if (!$this->getStorage($key)) {
                $this->setStorage($key, $data);
            }
            return $this->getStorage($key);
        }
        return $data;
    }

    /**
     * Data Generation
     *
     * @param string $type
     * @param array $params
     * @return string|null
     */
    public function getData(string $type, array $params = []): ?string
    {
        if (in_array($type, self::DATA_TYPES)) {
            switch ($type) {
                case $type === "posts":
                    return \json_encode($this->generatePosts());
                    break;
                case $type === "users":
                    return \json_encode($this->generateUsers());
                    break;
                case $type === "post":
                    return \json_encode($this->generatePost($params, true));
                    break;
                case $type === "user":
                    return \json_encode($this->generateUser($params, true));
                    break;
            }
        }
        return null;
    }
}
