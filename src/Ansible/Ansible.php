<?php

declare(strict_types=1);

namespace Peen\Ansible;

use Peen\Ansible\Command\AnsibleGalaxy;
use Peen\Ansible\Command\AnsibleGalaxyInterface;
use Peen\Ansible\Command\AnsiblePlaybook;
use Peen\Ansible\Command\AnsiblePlaybookInterface;
use Peen\Ansible\Exception\CommandException;
use Peen\Ansible\Process\ProcessBuilder;
use Peen\Ansible\Process\ProcessBuilderInterface;
use Peen\Ansible\Utils\Env;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

final class Ansible implements LoggerAwareInterface
{
    /**
     * Adds a local $logger instance and the setter.
     */
    use LoggerAwareTrait;

    private const DEFAULT_TIMEOUT = 300;

    private string $playbookCommand;

    private string $galaxyCommand;

    private string $ansibleBaseDir;

    private int $timeout;

    public function __construct(string $ansibleBaseDir, string $playbookCommand = '', string $galaxyCommand = '')
    {
        $this->ansibleBaseDir = $this->checkDir($ansibleBaseDir);
        $this->playbookCommand = $this->checkCommand($playbookCommand, 'ansible-playbook');
        $this->galaxyCommand = $this->checkCommand($galaxyCommand, 'ansible-galaxy');

        $this->timeout = Ansible::DEFAULT_TIMEOUT;
        $this->logger = new NullLogger();
    }

    /**
     * AnsiblePlaybook instance creator
     */
    public function playbook(): AnsiblePlaybookInterface
    {
        return new AnsiblePlaybook(
            $this->createProcess($this->playbookCommand),
            $this->logger
        );
    }

    /**
     * AnsibleGalaxy instance creator
     */
    public function galaxy(): AnsibleGalaxyInterface
    {
        return new AnsibleGalaxy(
            $this->createProcess($this->galaxyCommand),
            $this->logger
        );
    }

    /**
     * Set process timeout in seconds.
     */
    public function setTimeout(int $timeout): Ansible
    {
        $this->timeout = $timeout;

        return $this;
    }

    private function createProcess(string $prefix): ProcessBuilderInterface
    {
        $process = new ProcessBuilder($prefix, $this->ansibleBaseDir);

        return $process->setTimeout($this->timeout);
    }

    private function checkCommand(string $command, string $default): string
    {
        // normally ansible is in /usr/local/bin/*
        if (empty($command)) {
            if (Env::isWindows()) {
                return $default;
            }

            // not testable without ansible installation
            if (null === shell_exec('which ' . $default)) {
                throw new CommandException(sprintf('No "%s" executable present in PATH!', $default));
            }

            return $default;
        }

        // Here: we have a given command, just need to check it exists and it's executable
        if (!is_file($command)) {
            throw new CommandException(sprintf('Command "%s" does not exist!', $command));
        }

        if (!$this->isExecutable($command)) {
            throw new CommandException(sprintf('Command "%s" is not executable!', $command));
        }

        return $command;
    }

    private function checkDir(string $dir): string
    {
        if (!is_dir($dir)) {
            throw new CommandException('Ansible project root ' . $dir . ' not found!');
        }

        return $dir;
    }

    private function isExecutable(string $command): bool
    {
        if (empty($command)) {
            return false;
        }

        if (!Env::isWindows()) {
            return is_executable($command);
        }

        foreach (['exe', 'com', 'bat', 'cmd', 'ps1'] as $ext) {
            if (strtolower(substr($command, -3, 3)) === $ext) {
                return true;
            }
        }

        return false;
    }
}
