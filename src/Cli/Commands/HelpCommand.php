<?php

namespace FastApi\Cli\Commands;

use FastApi\Cli\Command;
use FastApi\Cli\CliPrinter;

class HelpCommand extends Command
{
    use CliPrinter;

    protected array $arguments = [
        'user'
    ];

    public function handle()
    {
        print_r($this->arguments());
    }
}