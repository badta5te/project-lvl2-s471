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

    public function testNestedJson()
    {
        $firstFilePath = __DIR__ . '/files/before2.json';
        $secondFilePath = __DIR__ . '/files/after2.json';
        $expected = file_get_contents(__DIR__ . '/files/expected2');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath));
    }

    public function testNestedYaml()
    {
        $firstFilePath = __DIR__ . '/files/before2.yaml';
        $secondFilePath = __DIR__ . '/files/after2.yaml';
        $expected = file_get_contents(__DIR__ . '/files/expected2');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath));
    }

    public function testPlain()
    {
        $firstFilePath = __DIR__ . '/files/before2.json';
        $secondFilePath = __DIR__ . '/files/after2.json';
        $expected = file_get_contents(__DIR__ . '/files/expectedPlain');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath, 'plain'));

        $firstFilePath = __DIR__ . '/files/before2.yaml';
        $secondFilePath = __DIR__ . '/files/after2.yaml';
        $expected = file_get_contents(__DIR__ . '/files/expectedPlain');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath, 'plain'));
    }

    public function testJson()
    {
        $firstFilePath = __DIR__ . '/files/before2.json';
        $secondFilePath = __DIR__ . '/files/after2.json';
        $expected = file_get_contents(__DIR__ . '/files/expectedJson');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath, 'json'));

        $firstFilePath = __DIR__ . '/files/before2.yaml';
        $secondFilePath = __DIR__ . '/files/after2.yaml';
        $expected = file_get_contents(__DIR__ . '/files/expectedJson');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath, 'json'));
    }
}
