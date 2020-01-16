<?php

declare(strict_types = 1);

namespace Phelpers;

use ReflectionFunction;

/**
 * Curry the given function with the provided arugments.
 *
 * @param callable $function Any PHP callable.
 * @param mixed $arguments Variadic set of arguments to pass the callable.
 * @return mixed
 */
function curry(callable $function, ...$arguments) {
    static $count = 0;
    $reflection = new ReflectionFunction($function);
    $arity = $reflection->getNumberOfRequiredParameters();

    return function ($argument) use ($function, $count, $arity) {
        $count++;

        if ($count >= $arity) {
            return $function($argument);
        }

        return curry(partial($function, $argument));
    };
}
