<?php

namespace Devscast;

use Devscast\Routing\Router;

/**
 * Class Server
 * @package Devscast
 * @author bernard-ng <ngandubernard@gmail.com>
 */
final class Server
{

    /** @var array */
    private array $postData = [];

    /**
     * Server constructor.
     */
    public function __construct()
    {
        $this->postData = $_POST;
    }

    /**
     * Handle OPTIONS request
     * @return void
     */
    public function handleOptionRequest(): void
    {
        $this->setResponseHeaders();
        echo "GET, POST, PUT, DELETE, PATCH, OPTIONS";
    }

    /**
     * Handle HTTP Request
     * @param string $route
     * @param string $method
     * @return void
     * @todo parse and use the request playload
     */
    public function handleRequest(string $route, string $method): void
    {
        $route = Router::getMatchedRoute($route, $method);

        if ($route) {
            switch ($method) {
                case $method === "GET":
                    $this->setResponseHeaders(200);
                    echo (new Generator())->getData($route->dataType, $route->params);
                    break;

                case $method === "POST":
                    $this->setResponseHeaders(201);
                    echo json_encode($this->postData);
                    break;

                case $method === "DELETE":
                    $this->setResponseHeaders(200);
                    echo json_encode([]);
                    break;

                case $method === "PUT":
                case $method === "PATCH":
                    $this->setResponseHeaders(200);
                    echo json_encode($this->postData);
                    break;
            }
        } else {
            $this->setResponseHeaders(404);
        }
    }

    /**
     * Set Request headers, Enable CORS
     *
     * @param integer $status
     * @return void
     */
    private function setResponseHeaders(int $status = 200): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
        header("X-Powered-By: devscast");
        http_response_code($status);
    }
}
