<?php

namespace Gendiff\Parser;
use Symfony\Component\Yaml\Yaml;

function parse($data, $extension)
{
    switch ($extension) {
        case 'json':
            return json_decode($data, true);
            break;
        case 'yaml':
            return Yaml::parse($data);
            break;
    }
}
