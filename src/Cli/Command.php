<?php

namespace FastApi\Cli;

abstract class Command
{
    /**
     * Accepted arguments.
     * 
     * @var array
     */
    protected array $arguments = [];

    /**
     * Options array.
     * 
     * @var array
     */
    protected array $options = [];

    /**
     * Console given arguments.
     * 
     * @var array
     */
    protected array $argv = [];

    /**
     * Create Command instnace.
     *
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        // Remove the cli file name from the argv
        array_shift($argv);
        // Remove the command name from the argv
        array_shift($argv);

        $this->argv = $argv;
    }

    /**
     * Handle the command.
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Get command name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get all arguments.
     *
     * @return void
     */
    public function arguments()
    {
        $arguments = [];

        foreach ($this->arguments as $key => $arg) {
            $arguments[$arg] = $this->argv[$key];
        }

        return $arguments;
    }
}