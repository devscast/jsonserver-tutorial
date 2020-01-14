<?php

namespace Devscast\Routing;

/**
 * Class Route
 * @package Devscast\Routing
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class Route
{
    /** @var string */
    public string $regex;

    /** @var string */
    public string $method;

    /** @var string */
    public string $dataType;

    /** @var array */
    public array $params = [];

    /**
     * @param string $method
     * @param string $dataType
     * @param string $regex
     * @param array $params
     */
    public function __construct(string $method, string $dataType, string $regex, array $params = [])
    {
        $this->regex = trim($regex, '/');
        $this->method = $method;
        $this->dataType = $dataType;
    }

    /**
     * @param string $path
     * @return self|null
     */
    public function match(string $path): ?self
    {

        if (preg_match_all("#^{$this->regex}$#", trim($path, '/'), $matches)) {
            array_shift($matches);

            if (isset($matches[0])) {
                $this->params = $matches[0];
            }
            return $this;
        }
        return null;
    }
}
