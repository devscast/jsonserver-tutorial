<?php

namespace Devscast\Routing;


class Route
{
    public string $regex;

    public string $method;

    public string $dataType;

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
