<?php

namespace app\Containers;

use ReflectionClass;

class Container
{
    private static array $objects = [];

    public static function has(string $id): bool
    {
        return isset($self::objects[$id]) || class_exists($id);
    }

    public static function get(string $id): mixed
    {
        return self::$objects[$id] ?? self::prepareObject($id);
    }

    public static function set(string $id, $value): void
    {
        self::$objects[$id] = $value;
    }

    private static function prepareObject(string $class): object
    {
        $classReflector = new ReflectionClass($class);

        // Получаем рефлектор конструктора класса, проверяем - есть ли конструктор
        // Если конструктора нет - сразу возвращаем экземпляр класса
        $constructReflector = $classReflector->getConstructor();
        if (empty($constructReflector)) {
            return new $class;
        }

        // Получаем рефлекторы аргументов конструктора
        // Если аргументов нет - сразу возвращаем экземпляр класса
        $constructArguments = $constructReflector->getParameters();
        if (empty($constructArguments)) {
            return new $class;
        }

        // Перебираем все аргументы конструктора, собираем их значения
        $args = [];
        foreach ($constructArguments as $argument) {
            // Получаем тип аргумента
            $argumentType = $argument->getType()->getName();
            // Получаем сам аргумент по его типу из контейнера
            $args[$argument->getName()] = self::get($argumentType);
        }

        // И возвращаем экземпляр класса со всеми зависимостями
        return new $class(...$args);
    }

}