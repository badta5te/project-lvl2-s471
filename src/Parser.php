<?php

namespace Gendiff\Parser;
use Symfony\Component\Yaml\Yaml;

function parse($data, $dataType)
{
    switch ($dataType) {
        case 'json':
            return json_decode($data, true);
            break;
        case 'yaml':
            return Yaml::parse($data);
            break;
    }
}
