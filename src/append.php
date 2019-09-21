<?php

declare(strict_types = 1);

namespace Phelpers;

use InvalidArgumentException;

/**
 * Append an item to a given subject.
 *
 * @param mixed $tail
 * @param array|string|int|float $subject
 * @param string $delimiter
 * @return array|string
 */
function append($tail, $subject, string $delimiter = '') {
    $isStringable = function ($subject): bool {
        return \is_string($subject) or \is_numeric($subject);
    };
    
    if ($isStringable($subject) and !$isStringable($tail)) {
        throw new InvalidArgumentException(\sprintf('Arguments 1 and 2 passed to %s must be of the type %s, %s|%s given', __FUNCTION__, 'string', \gettype($tail), \gettype($subject)));
    } else if (!\is_array($subject) and !$isStringable($subject)) {
        throw new InvalidArgumentException(\sprintf('Argument 2 passed to %s must be of the type %s, %s given', __FUNCTION__, 'array', \gettype($subject)));
    }

    if (\is_array($subject)) {
        $subject[] = $tail;

        return $subject;
    }

    return $subject.$delimiter.$tail;
}