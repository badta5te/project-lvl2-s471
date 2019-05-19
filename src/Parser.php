<?php

namespace Gendiff\Parser;
use Symfony\Component\Yaml\Yaml;

function getExtension($path)
{
    $extension = pathinfo($path);
    return $extension['extension'];
}

function getData($path)
{
    $extension = getExtension($path);
    switch ($extension) {
        case 'json':
            return json_decode(file_get_contents($path), true);
            break;
        case 'yaml':
            return Yaml::parse(file_get_contents($path));
            break;
    }
}
