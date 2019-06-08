<?php

namespace Gendiff\Engine;
use function Gendiff\Parser\parse;
use function Gendiff\AST\getAST;
use function Gendiff\Formatters\PrettyRender\getPrettyData;
use function Gendiff\Formatters\PlainRender\getPlainData;
use function Gendiff\Formatters\JsonRender\getJsonData;

function getDataType($path)
{
    $dataType = pathinfo($path);
    return $dataType['extension'];
}

function getDiff($pathFirst, $pathSecond, $format = 'pretty')
{
    $dataTypeFileBefore = getDataType($pathFirst);
    $dataTypeFileAfter = getDataType($pathSecond);

    $getContentFileBefore = file_get_contents($pathFirst);
    $getContentFileAfter = file_get_contents($pathSecond);

    $getDataBefore = parse($getContentFileBefore, $dataTypeFileBefore);
    $getDataAfter = parse($getContentFileAfter, $dataTypeFileAfter);

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
