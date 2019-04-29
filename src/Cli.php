<?php

namespace Gendiff\Cli;

use Docopt;

function run()
{
    $doc = <<<DOC
    Generate diff

    Usage:
      gendiff (-h|--help)
      gendiff [--format <fmt>] <firstFile> <secondFile>

    Options:
      -h --help                     Show this screen
      --format <fmt>                Report format [default: pretty]

    DOC;

    Docopt::handle($doc);
}
