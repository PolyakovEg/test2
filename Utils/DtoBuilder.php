<?php

namespace app\Utils;

use ReflectionClass;

class DtoBuilder
{
    public static function formFromRequest(string $class, array $requestBody): mixed
    {
        $instance = new $class();
        $vars = get_class_vars($class);

        foreach ($vars as $key=>$value) {
            $instance->$key = $requestBody[$key];
        }

        return $instance;
    }
}