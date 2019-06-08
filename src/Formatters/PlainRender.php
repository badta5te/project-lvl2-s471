<?php

namespace Gendiff\Formatters\PlainRender;

function getPlainData($ast, $separator = '')
{
    $parsedAST = array_reduce($ast, function ($acc, $node) use ($separator) {
        [
            'type' => $type,
            'key' => $key,
            'valueBefore' => $valueBefore,
            'valueAfter' => $valueAfter,
            'children' => $children
        ] = $node;

        $valueBefore = is_array($valueBefore) ? 'complex value' : $valueBefore;
        $valueAfter = is_array($valueAfter) ? 'complex value' : $valueAfter;

        switch ($type) {
            case 'node':
                $acc[] = getPlainData($children, "{$separator}{$key}.");
                break;
            case 'changed':
                $acc[] = "Property '{$separator}{$key}' was changed. From '{$valueBefore}' to '{$valueAfter}'";
                break;
            case 'deleted':
                $acc[] = "Property '{$separator}{$key}' was removed";
                break;
            case 'added':
                $acc[] = "Property '{$separator}{$key}' was added with value: '{$valueAfter}'";
                break;
        }
        return $acc;
    }, []);
    return implode(PHP_EOL, $parsedAST);
}
