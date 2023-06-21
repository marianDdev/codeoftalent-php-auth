<?php

declare(strict_types=1);

namespace App;

use Exception;

class Router
{
    protected array $routes = [];

    private const GET_METHOD  = 'GET';
    private const POST_METHOD = 'POST';

    public function add(string $method, string $uri, string $controller): self
    {
        $this->routes[] = [
            'uri'        => $uri,
            'controller' => $controller,
            'method'     => $method,
        ];

        return $this;
    }

    public function get(string $uri, $controller): self
    {
        return $this->add(self::GET_METHOD, $uri, $controller);
    }

    public function post(string $uri, $controller): self
    {
        return $this->add(self::POST_METHOD, $uri, $controller);
    }

    /**
     * @throws Exception
     */
    public function route($uri, $method): void
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                $controller = ServiceContainer::resolve($route['controller']);
                $controller();
            }
        }
    }
}