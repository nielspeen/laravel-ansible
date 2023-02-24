<?php

namespace Peen\Ansible\Process;

use Symfony\Component\Process\Process;

interface ProcessBuilderInterface
{
    public function setArguments(array $arguments): ProcessBuilderInterface;

    public function setTimeout(int $timeout): ProcessBuilderInterface;

    public function setEnv(string $name, string|int $value): ProcessBuilderInterface;

    public function getProcess(): Process;
}
