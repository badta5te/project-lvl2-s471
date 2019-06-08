<?php

namespace Gendiff\Formatters\PrettyRender;

function getPrettyData($ast, $level = 0)
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
                $acc[] = $separator . "    {$key}: " . getPrettyData($children, $level + 1);
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
    if (!is_array($value)) {
        return $value;
    }

    $separator = str_repeat('    ', $level + 1);
    $keys = array_keys($value);
    $data =  array_map(function ($key) use ($value, $separator, $level) {
        return "    {$key}: {$value[$key]}";
    }, $keys);
    $string = implode(PHP_EOL, $data);
    $result = '{' . PHP_EOL . "{$separator}" . $string . PHP_EOL . "{$separator}" . '}';
    return $result;
}
