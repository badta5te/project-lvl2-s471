<?php

namespace Gendiff\Engine;
use function Funct\Collection\union;

function getDataFromFile($file)
{
    return file_get_contents($file);
}

function getJson($data)
{
    return json_decode($data, true);
}

function getStringFromBool($data)
{
    return array_map(function ($value) {
        return is_bool($value) ? ($value = $value ? 'true' : 'false') : $value;
    }, $data);
}

function getDiff($pathFirst, $pathSecond)
{
    $dataBefore = getStringFromBool(getJson(getDataFromFile($pathFirst)));
    $dataAfter = getStringFromBool(getJson(getDataFromFile($pathSecond)));

    $unionData = array_keys(union($dataBefore, $dataAfter));

    $array = array_reduce($unionData, function ($acc, $key) use ($dataBefore, $dataAfter) {
        if (array_key_exists($key, $dataBefore) && array_key_exists($key, $dataAfter)) {
            if ($dataBefore[$key] == $dataAfter[$key]) {
                $acc[] = "    {$key}: {$dataBefore[$key]}";
            } else {
                $acc[] = "  + {$key}: {$dataAfter[$key]}";
                $acc[] = "  - {$key}: {$dataBefore[$key]}";
            }
        } elseif (array_key_exists($key, $dataBefore) && !array_key_exists($key, $dataAfter)) {
            $acc[] = "  - {$key}: {$dataBefore[$key]}";
        } else {
            $acc[] = "  + {$key}: {$dataAfter[$key]}";
        }
        return $acc;
    }, []);

    $result = implode(PHP_EOL, $array);
    return '{' . PHP_EOL . $result . PHP_EOL . '}';
}
