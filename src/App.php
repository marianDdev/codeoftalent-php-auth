<?php

namespace App;

use Exception;

class App
{
    protected static Container $container;

    public static function setContainer(Container $container): void
    {
        static::$container = $container;
    }

    public static function bind($key, $resolver): void
    {
        self::$container->bind($key, $resolver);
    }

    /**
     * @throws Exception
     */
    public static function resolve($key)
    {
        return self::$container->resolve($key);
    }
}
