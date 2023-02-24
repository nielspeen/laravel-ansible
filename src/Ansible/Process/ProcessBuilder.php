<?php

namespace Peen\Ansible\Process;

use Symfony\Component\Process\Process;

/**
 * Wrapper for symfony process component to allow for command option/argument collection before execute
 */
class ProcessBuilder implements ProcessBuilderInterface
{
    private array $arguments;

    private int $timeout;

    private string $path;

    private array $envVars;

    /**
     * ProcessBuilder constructor.
     */
    public function __construct(string $command, string $path)
    {
        $this->arguments = [$command];
        $this->path = $path;
        $this->timeout = 900;
        $this->envVars = [];
    }

    public function setArguments(array $arguments): ProcessBuilderInterface
    {
        if (!empty($this->arguments)) {
            $this->arguments = array_merge($this->arguments, $arguments);
        } else {
            $this->arguments = $arguments;
        }

        return $this;
    }

    public function setTimeout(int $timeout): ProcessBuilderInterface
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function setEnv(string $name, string|int $value): ProcessBuilderInterface
    {
        $this->envVars[$name] = $value;

        return $this;
    }

    public function getProcess(): Process
    {
        return (
            new Process(
                $this->arguments,
                $this->path
            )
        )
        ->setTimeout($this->timeout)
        ->setEnv($this->envVars);
    }
}
