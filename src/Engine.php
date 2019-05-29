<?php

namespace Gendiff\Engine;
use function Gendiff\Parser\parse;
use function Gendiff\AST\getAST;
use function Gendiff\PrettyRender\getPrettyData;
use function Gendiff\PlainRender\getPlainData;
use function Gendiff\JsonRender\getJsonData;

function getExtension($path)
{
    $extension = pathinfo($path);
    return $extension['extension'];
}

function getDiff($pathFirst, $pathSecond, $format = 'pretty')
{
    $extensionFileBefore = getExtension($pathFirst);
    $extensionFileAfter = getExtension($pathSecond);

    $getContentFileBefore = file_get_contents($pathFirst);
    $getContentFileAfter = file_get_contents($pathSecond);

    $getDataBefore = parse($getContentFileBefore, $extensionFileBefore);
    $getDataAfter = parse($getContentFileAfter, $extensionFileAfter);

    $ast = getAST($getDataBefore, $getDataAfter);

    switch ($format) {
        case 'plain':
            return getPlainData($ast);
            break;
        case 'json':
            return getJsonData($ast);
            break;
        case 'pretty':
            return getPrettyData($ast);
            break;
    }
}
