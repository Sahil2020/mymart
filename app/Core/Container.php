<?php

declare(strict_types=1);

namespace App\Core;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
class Container
{
    private array $instances = [];
    public function make(string $class): object
    {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }
        $reflection = new ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new \Exception("Class {$class} is not instantiable.");
        }

        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $class();
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            $dependencies[] = $this->resolve($parameter);
        }

        $instance = $reflection->newInstanceArgs($dependencies);

        $this->instances[$class] = $instance;

        return $instance;

    }

    private function resolve(ReflectionParameter $parameter): object
    {
        $type = $parameter->getType();

        if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
            throw new \Exception("Unable to resolve {$parameter->getName()}");
        }

        return $this->make($type->getName());
    }
}