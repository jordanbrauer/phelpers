<?php

declare(strict_types = 1);

namespace Phelpers;

use Closure;

function benchmark(Closure $closure, int $iterations = 1000000): object {
    $values = \array_map(function ($minimum) use ($iterations) {
        return \mt_rand($minimum, $iterations);
    }, \array_fill(0, $iterations, 1));
    $time = -\microtime(\true);
    $ruBegin = \getrusage();

    for ($i = 0; $i < $iterations; $i++) {
        $closure($values[$i]);
    }

    $allocatedMemory = \memory_get_usage(\true);
    $ruEnd = \getrusage();
    $time += \microtime(\true);
    $calcRuTime = function ($ru, $rus, $index) {
        return (($ru["ru_{$index}.tv_sec"] * 1000) + \intval(($ru["ru_{$index}.tv_usec"] / 1000))) - (($rus["ru_{$index}.tv_sec"] * 1000) + \intval(($rus["ru_{$index}.tv_usec"] / 1000)));
    };
    $calcMemUsage = function ($x) {
        return @\round($x / \pow(1024, ($i = \floor(\log($x, 1024)))), 2).' '.['b', 'kb', 'mb', 'gb', 'tb', 'pb'][$i];
    };

    return (object) [
        "iterations" => \number_format($iterations)."   ",
        "memory_usage" => $calcMemUsage($allocatedMemory),
        "clock_time: " => \number_format($time, 2)." s",
        "process_computation_time: " => "{$calcRuTime($ruEnd, $ruBegin, 'utime')} ms",
        "system_call_time" => "{$calcRuTime($ruEnd, $ruBegin, 'stime')} ms",
        "iterations_per_second" => \number_format(($iterations / $time), 0),
    ];
}
