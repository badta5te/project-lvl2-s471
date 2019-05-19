<?php

namespace Gendiff\AST;

use function Funct\Collection\union;
use function Gendiff\Parser\getData;

function getStringFromBool($data)
{
    return array_map(function ($value) {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif (is_array($value)) {
            return getStringFromBool($value);
        } else {
            return $value;
        }
    }, $data);
}

function getNode($type, $key, $valueBefore, $valueAfter, $children)
{
    return [
        'type' => $type,
        'key' => $key,
        'valueBefore' => $valueBefore,
        'valueAfter' => $valueAfter,
        'children' => $children
    ];
}

function getAST($getDataBefore, $getDataAfter)
{
    $dataBefore = getStringFromBool($getDataBefore);
    $dataAfter = getStringFromBool($getDataAfter);


    $unionKeys = union(array_keys($dataBefore), array_keys($dataAfter));

    $ast = array_reduce($unionKeys, function ($acc, $key) use ($dataBefore, $dataAfter) {
        if (array_key_exists($key, $dataBefore) && array_key_exists($key, $dataAfter)) {
            if (is_array($dataBefore[$key]) && is_array($dataAfter[$key])) {
                $acc[] = getNode('node', $key, null, null, getAST($dataBefore[$key], $dataAfter[$key]));
            } elseif ($dataBefore[$key] == $dataAfter[$key]) {
                $acc[] = getNode('unchanged', $key, $dataBefore[$key], $dataAfter[$key], null);
            } else {
                $acc[] = getNode('changed', $key, $dataBefore[$key], $dataAfter[$key], null);
            }
        } elseif (!array_key_exists($key, $dataAfter)) {
            $acc[] = getNode('deleted', $key, $dataBefore[$key], null, null);
        } else {
            $acc[] = getNode('added', $key, null, $dataAfter[$key], null);
        }
        return $acc;
    }, []);
    return $ast;
}

function parseAST($ast, $level = 0)
{
    $separator = str_repeat('    ', $level);
    $parsedAST = array_reduce($ast, function ($acc, $node) use ($separator, $level) {
        [
            'type' => $type,
            'key' => $key,
            'valueBefore' => $valueBefore,
            'valueAfter' => $valueAfter,
            'children' => $children
        ] = $node;

        switch ($type) {
            case 'node':
                $acc[] = $separator . "    {$key}: " . parseAST($children, $level + 1);
                break;
            case 'changed':
                $before = $separator . "  - {$key}: " . toString($valueBefore, $level);
                $after = $separator . "  + {$key}: " . toString($valueAfter, $level);
                $acc[] = "{$after}" . PHP_EOL . "{$before}";
                break;
            case 'unchanged':
                $acc[] = $separator . "    {$key}: " . toString($valueBefore, $level);
                break;
            case 'deleted':
                $acc[] = $separator . "  - {$key}: " . toString($valueBefore, $level);
                break;
            case 'added':
                $acc[] = $separator . "  + {$key}: " . toString($valueAfter, $level);
                break;
        }
        return $acc;
    }, []);
    $result = implode(PHP_EOL, $parsedAST);
    return '{' . PHP_EOL . $result . PHP_EOL . $separator .  '}';
}

function toString($value, $level)
{
    if (is_array($value)) {
        $separator = str_repeat('    ', $level + 1);
        $keys = array_keys($value);
        $data =  array_map(function ($key) use ($value, $separator, $level) {
            return "    {$key}: {$value[$key]}";
        }, $keys);
        $string = implode(PHP_EOL, $data);
        $result = '{' . PHP_EOL . "{$separator}" . $string . PHP_EOL . "{$separator}" . '}';
        return $result;
    }
    return $value;
}
