<?php

declare(strict_types = 1);

/**
 * This file is part of the jordanbrauer/phelpers PHP library.
 *
 * @copyright 2021 Jordan Brauer <18744334+jordanbrauer@users.noreply.github.com>
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phelpers\Tests\Unit;

use Exception;

use function Phelpers\retry;

it('retries', function (): void {
    $actual = 0;
    $expected = 10;

    retry($expected, function () use (&$actual, $expected) {
        $actual++;

        if ($actual < $expected) {
            throw new Exception();
        }
    });

    expect($actual)->toBe($expected);
});
