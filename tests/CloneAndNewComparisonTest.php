<?php
/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 28.09.17 6:55.
 */

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Fixtures\CloneVsNewClass;

class CloneAndNewComparisonTest extends TestCase
{
    private const TRIES = 16;
    private const ITERATIONS = 1048576;

    public function testCloneVsNew()
    {
        $cloneAvg = $this->getCloneAvg();
        $newAvg = $this->getNewAvg();
        $this->assertLessThan($newAvg, $cloneAvg);
        $faster = intval(100 * ($newAvg - $cloneAvg) / $newAvg);
        fwrite(STDERR, sprintf('clone is %d%% faster than new', $faster));
    }

    private function getCloneAvg()
    {
        $tests = [];
        for ($test = 0; $test < self::TRIES; $test++) {
            $t1 = microtime(true);
            $prototype = new CloneVsNewClass();
            for ($i = 0; $i < self::ITERATIONS; $i++) {
                $tmp = clone $prototype;
            }
            $tests[$test] = microtime(true) - $t1;
        }

        $avg = array_sum($tests) / count($tests);
        fwrite(STDERR, sprintf("clone avg: %f\n", $avg));

        return $avg;
    }

    private function getNewAvg()
    {
        $tests = [];
        for ($test = 0; $test < self::TRIES; $test++) {
            $t1 = microtime(true);
            for ($i = 0; $i < self::ITERATIONS; $i++) {
                $tmp = new CloneVsNewClass();
            }
            $tests[$test] = microtime(true) - $t1;
        }

        $avg = array_sum($tests) / count($tests);
        fwrite(STDERR, sprintf("new avg: %f\n", $avg));

        return $avg;
    }

}