<?php

namespace Gendiff\Tests;

use function Gendiff\Engine\getDiff;
use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
    public function testEngineJson()
    {
        $firstFilePath = __DIR__ . '/files/before.json';
        $secondFilePath = __DIR__ . '/files/after.json';
        $expected = file_get_contents(__DIR__ . '/files/expected');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath));
    }

    public function testEngineYaml()
    {
        $firstFilePath = __DIR__ . '/files/before.yaml';
        $secondFilePath = __DIR__ . '/files/after.yaml';
        $expected = file_get_contents(__DIR__ . '/files/expected');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath));
    }
}
