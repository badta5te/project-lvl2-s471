<?php

namespace Gendiff\Engine;
use function Gendiff\Parser\getData;
use function Gendiff\AST\getAST;
use function Gendiff\AST\parseAST;
use function Gendiff\DefaultRender\getDefaultData;
use function Gendiff\PlainRender\getPlainData;
use function Gendiff\JsonRender\getJsonData;

function getDiff($pathFirst, $pathSecond, $format = 'pretty')
{
    $getDataBefore = getData($pathFirst);
    $getDataAfter = getData($pathSecond);

    $ast = getAST($getDataBefore, $getDataAfter);

    if ($format === 'plain') {
        return getPlainData($ast);
    } elseif ($format === 'json') {
        return getJsonData($ast);
    }

    return getDefaultData($ast);
}
