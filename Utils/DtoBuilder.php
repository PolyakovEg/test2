<?php

namespace app\Utils;

class DtoBuilder
{
    /**
     * Создает Dto по телу запроса.
     *
     * @param string $class
     * @param array $requestBody
     * @return mixed
     */
    public static function formFromRequest(string $class, array $requestBody): mixed
    {
        $instance = new $class();
        $vars = get_class_vars($class);

        foreach ($vars as $key => $value) {
            $instance->$key = $requestBody[$key];
        }

        return $instance;
    }
}