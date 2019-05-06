<?php

namespace Gendiff\Cli;
use function Gendiff\Engine\getDiff;
use Docopt;

const FAQ = <<<EOL
Generate diff
Usage:
  gendiff (-h| --help)
  gendiff [--format <fmt>] <firstFile> <secondFile>
Options:
  -h --help                     Show this screen
  --format <fmt>                Report format [default: pretty]
EOL;

function run()
{
    $data = Docopt::handle(FAQ);
    $pathFirst = $data->args['<firstFile>'];
    $pathSecond = $data->args['<secondFile>'];
    //var_dump($pathFirst);
    var_dump(getDiff($pathFirst, $pathSecond));
}
