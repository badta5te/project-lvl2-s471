<?php

namespace Gendiff\Tests;

use function Gendiff\Engine\getDiff;
use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
    public function testEngine()
    {
        $firstFilePath = __DIR__ . '/before.json';
        $secondFilePath = __DIR__ . '/after.json';
        $expected = file_get_contents(__DIR__ . '/expected');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath));
    }
}
