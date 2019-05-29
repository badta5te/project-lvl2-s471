<?php

namespace Gendiff\Tests;

use function Gendiff\Engine\getDiff;
use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
    public function testStraight()
    {
        $firstFilePath = 'tests/files/before.json';
        $secondFilePath = 'tests/files/after.json';
        $expected = file_get_contents('tests/files/expected');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath));

        $firstFilePath = 'tests/files/before.yaml';
        $secondFilePath = 'tests/files/after.yaml';
        $expected = file_get_contents('tests/files/expected');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath));
    }

    public function testNested()
    {
        $firstFilePath = 'tests/files/before2.json';
        $secondFilePath = 'tests/files/after2.json';
        $expected = file_get_contents('tests/files/expected2');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath));

        $firstFilePath = 'tests/files/before2.yaml';
        $secondFilePath = 'tests/files/after2.yaml';
        $expected = file_get_contents('tests/files/expected2');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath));
    }

    public function testPlain()
    {
        $firstFilePath = 'tests/files/before2.json';
        $secondFilePath = 'tests/files/after2.json';
        $expected = file_get_contents('tests/files/expectedPlain');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath, 'plain'));

        $firstFilePath = 'tests/files/before2.yaml';
        $secondFilePath = 'tests/files/after2.yaml';
        $expected = file_get_contents('tests/files/expectedPlain');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath, 'plain'));
    }

    public function testJson()
    {
        $firstFilePath = 'tests/files/before2.json';
        $secondFilePath = 'tests/files/after2.json';
        $expected = file_get_contents('tests/files/expectedJson');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath, 'json'));

        $firstFilePath = 'tests/files/before2.yaml';
        $secondFilePath = 'tests/files/after2.yaml';
        $expected = file_get_contents('tests/files/expectedJson');
        $this->assertEquals($expected, getDiff($firstFilePath, $secondFilePath, 'json'));
    }
}
