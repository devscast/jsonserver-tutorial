<?php

namespace Devscast\Routing;

/**
 * Class Router
 * @package Devscast\Routing
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class Router
{
    /**
     * Provide All Route
     *
     * @return array
     */
    private static function getRoutes(): array
    {
        return [
            "GET" => [
                new Route("GET", "post", "/posts/([0-9]+)"),
                new Route("GET", "user", "/users/([0-9]+)"),
                new Route("GET", "posts", "/posts"),
                new Route("GET", "users", "/users"),
            ],
            "POST" => [
                new Route("POST", "posts", "/posts"),
                new Route("POST", "users", "/users")
            ],
            "PUT" => [
                new Route("PUT", "post", "/posts/([0-9]+)"),
                new Route("PUT", "user", "/users/([0-9]+)"),
            ],
            "DELETE" => [
                new Route("DELETE", "post", "/posts/([0-9]+)"),
                new Route("DELETE", "user",  "/users/([0-9]+)"),
            ],
        ];
    }

    /**
     * Get the route matched by the current request
     *
     * @param string $path
     * @param string $method
     * @return Route|null
     */
    public static function getMatchedRoute(string $path, string $method): ?Route
    {
        $routes = self::getRoutes()[$method] ?? null;
        if ($routes) {
            foreach ($routes as $route) {
                if ($route->match($path)) {
                    return $route;
                }
            }
        }
        return null;
    }
}
