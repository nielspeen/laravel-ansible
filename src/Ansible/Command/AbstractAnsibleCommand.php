<?php

namespace Peen\Ansible\Command;

use Peen\Ansible\Process\ProcessBuilderInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Process\Process;

abstract class AbstractAnsibleCommand
{
    /**
     * Adds a local $logger instance and the setter.
     */
    use LoggerAwareTrait;

    protected ProcessBuilderInterface $processBuilder;

    /**
     * @var Option[]
     */
    private array $options;

    private array $parameters;

    private array $baseOptions;

    /**
     * @param ProcessBuilderInterface $processBuilder
     */
    public function __construct(ProcessBuilderInterface $processBuilder)
    {
        $this->processBuilder = $processBuilder;
        $this->options = [];
        $this->parameters = [];
        $this->baseOptions = [];
        $this->setLogger(\Log::getLogger());
    }

    /**
     * Get parameter string which will be used to call ansible.
     */
    protected function prepareArguments(bool $asArray = true): string|array
    {
        $arguments = array_merge(
            [$this->getBaseOptions()],
            $this->getOptions(),
            $this->getParameters()
        );

        if (false === $asArray) {
            $arguments = implode(' ', $arguments);
        }

        return $arguments;
    }

    /**
     * Add an Option.
     */
    protected function addOption(string $name, int|string $value): void
    {
        $this->options[] = new Option($name, (string)$value);
    }

    /**
     * Add a parameter.
     */
    protected function addParameter(string $name): void
    {
        $this->parameters[] = $name;
    }

    /**
     * Get all options as array.
     */
    protected function getOptions(): array
    {
        $options = [];

        foreach ($this->options as $option) {
            $options[] = $option->toString();
        }

        return $options;
    }

    /**
     * Get all parameters as array.
     */
    protected function getParameters(): array
    {
        return $this->parameters;
    }


    /**
     * Add base options to internal storage.
     */
    protected function addBaseOption(string $baseOption): self
    {
        $this->baseOptions[] = $baseOption;

        return $this;
    }

    /**
     * Generate base options string.
     */
    protected function getBaseOptions(): string
    {
        return implode(' ', $this->baseOptions);
    }

    /**
     * Check if param is array or string and implode with glue if necessary.
     */
    protected function checkParam(string|array $param, string $glue = ' '): string
    {
        if (is_array($param)) {
            $param = implode($glue, $param);
        }

        return $param;
    }

    /**
     * Creates process with processBuilder builder and executes it.
     * Has to return the process exit code in case of error
     */
    protected function runProcess(?callable $callback): int|string
    {
        $process = $this->processBuilder
            ->setArguments(
                $this->prepareArguments()
            )
            ->getProcess();

        // Logging the command
        $this->logger->debug('Executing: ' . $this->getProcessCommandline($process));

        // exit code
        $result = $process->run($callback);

        // text-mode
        if (null === $callback) {
            $result = $process->getOutput();

            if (false === $process->isSuccessful()) {
                $process->getErrorOutput();
            }
        }

        return $result;
    }

    /**
     * Builds the complete commandline inclusive of the environment variables.
     */
    protected function getProcessCommandline(Process $process): string
    {
        $commandline = $process->getCommandLine();
        if (count($process->getEnv()) === 0) {
            return $commandline;
        }

        // Here: we also need to dump the environment variables
        $vars = [];
        foreach ($process->getEnv() as $var => $value) {
            $vars[] = sprintf('%s=\'%s\'', $var, $value);
        }

        return sprintf('%s %s', implode(' ', $vars), $commandline);
    }
}
