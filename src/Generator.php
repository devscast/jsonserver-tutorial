<?php

namespace Devscast;

use Faker\Factory;
use Faker\Generator as FakerGenerator;

final class Generator
{
    private FakerGenerator $faker;

    private array $storage = [];

    private const DATA_TYPES = [
        "posts",
        "users",
        "post",
        "user"
    ];

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
        $this->storage = $_SESSION;
    }

    /**
     * Generate Posts and store in session
     *
     * @param integer $number
     * @return array
     */
    private function generatePosts(int $number = 100): array
    {
        if (!isset($this->storage['api_posts'])) {
            for ($i = 1; $i <= $number; $i++) {
                $this->storage['api_posts'][] = $this->generatePost([$i], false);
            }
        }
        return $this->storage['api_posts'];
    }

    /**
     * Generate Users and store in session
     *
     * @param integer $number
     * @return array
     */
    private function generateUsers(int $number = 100): array
    {
        if (!isset($this->storage['api_users'])) {
            for ($i = 1; $i <= $number; $i++) {
                $this->storage['api_users'][] = $this->generateUser([$i], false);
            }
        }
        return $this->storage['api_users'];
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

        $this->getFromStorage("api_users_{$id}", $user, $useStorage);
        return $user;
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

        $this->getFromStorage("api_post_{$id}", $post, $useStorage);
        return $post;
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
            if (!isset($this->storage[$key])) {
                $this->storage[$key] = $data;
            }
            return $this->storage[$key];
        }
    }

    /**
     * Data Generation Depeding from the type
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
                    $data = \json_encode($this->generatePosts());
                    break;
                case $type === "users":
                    $data = \json_encode($this->generateUsers());
                    break;
                case $type === "post":
                    $data = \json_encode($this->generatePost($params));
                    break;
                case $type === "user":
                    $data = \json_encode($this->generateUser($params));
                    break;
            }
            return $data;
        }
        return null;
    }
}
