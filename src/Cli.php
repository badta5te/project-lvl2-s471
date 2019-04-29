<?php

namespace Gendiff\Cli;

use Docopt;

$doc = <<<DOC
Generate dif
Usage:
  gendiff (-h|--help)
  gendiff [--format <fmt>] <firstFile> <secondFile
Options:
  -h --help                     Show this screen
  --format <fmt>                Report format [default: pretty
DOC;

function run()
{
    Docopt::handle($doc);
}
