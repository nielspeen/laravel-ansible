<?php

namespace Peen\Ansible\Command;

use Psr\Log\LoggerAwareInterface;

interface AnsibleCommandInterface extends LoggerAwareInterface
{
    /**
     * Executes a command process.
     * Returns either exit code or string output if no callback is given.
     */
    public function execute(?callable $callback = null): int|string;

    /**
     * Get parameter string which will be used to call ansible.
     */
    public function getCommandlineArguments(bool $asArray = true): string|array;
}
