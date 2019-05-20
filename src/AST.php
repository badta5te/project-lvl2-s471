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
