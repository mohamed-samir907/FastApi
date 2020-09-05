<?php

namespace FastApi\Cli;

class App
{
    /**
     * Commands Container.
     *
     * @var array
     */
    protected array $commands = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        // 
    }

    /**
     * Run the given command.
     *
     * @param  array $argv
     * @return void
     */
    public function runCommand(array $argv = [])
    {
        $name = "help";

        if (isset($argv[1])) {
            $name = $argv[1];
        }

        $command = $this->getCommand($name);

        if (!$command) {
            echo "ERROR: Command $name not found\n";
            exit;
        }

        $command = new $command($argv);
        $command->handle();
    }

    /**
     * Register Command.
     *
     * @param  array $commandsFile
     * @return void
     */
    public function registerCommands(array $commandsFile)
    {
        $this->commands = array_merge($this->commands, $commandsFile);
    }

    /**
     * Get registered command.
     *
     * @param  string $name
     * @return callable|null
     */
    public function getCommand($name)
    {
        return $this->commands[$name] ?? null;
    }
}
