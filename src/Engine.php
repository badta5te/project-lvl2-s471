<?php

namespace Gendiff\Engine;
use function Gendiff\Parser\getData;
use function Gendiff\AST\getAST;
use function Gendiff\AST\parseAST;

function getDiff($pathFirst, $pathSecond)
{
    $getDataBefore = getData($pathFirst);
    $getDataAfter = getData($pathSecond);

    $ast = getAST($getDataBefore, $getDataAfter);
    $result = parseAST($ast);
    return $result;
}
