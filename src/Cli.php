<?php

namespace Gendiff\Cli;
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
    Docopt::handle(FAQ);
}
