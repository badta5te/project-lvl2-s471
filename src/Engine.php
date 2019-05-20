<?php

namespace Gendiff\Engine;
use function Gendiff\Parser\getData;
use function Gendiff\AST\getAST;
use function Gendiff\AST\parseAST;
use function Gendiff\DefaultRender\getDefaultData;
use function Gendiff\PlainRender\getPlainData;

function getDiff($pathFirst, $pathSecond, $format = 'pretty')
{
    $getDataBefore = getData($pathFirst);
    $getDataAfter = getData($pathSecond);

    $ast = getAST($getDataBefore, $getDataAfter);

    if ($format === 'plain') {
        return getPlainData($ast);
    }
    return getDefaultData($ast);
}
