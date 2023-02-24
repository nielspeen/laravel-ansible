<?php

declare(strict_types=1);

namespace Peen\Ansible\Command;

interface AnsiblePlaybookInterface extends AnsibleCommandInterface
{
    /**
     * The play to be executed.
     */
    public function play(string $playbook): AnsiblePlaybookInterface;

    /**
     * Ask for SSH password.
     */
    public function askPass(): AnsiblePlaybookInterface;

    /**
     * Ask for su password.
     */
    public function askSuPass(): AnsiblePlaybookInterface;

    /**
     * Ask for sudo password.
     */
    public function askBecomePass(): AnsiblePlaybookInterface;

    /**
     * Ask for vault password.
     */
    public function askVaultPass(): AnsiblePlaybookInterface;

    /**
     * Enable privilege escalation
     */
    public function become(): AnsiblePlaybookInterface;

    /**
     * Desired become user (default=root).
     */
    public function becomeUser(string $user = 'root'): AnsiblePlaybookInterface;

    /**
     * Don't make any changes; instead, try to predict some of the changes that may occur.
     */
    public function check(): AnsiblePlaybookInterface;

    /**
     * Connection type to use (default=smart).
     */
    public function connection(string $connection = 'smart'): AnsiblePlaybookInterface;

    /**
     * When changing (small) files and templates, show the
     * differences in those files; works great with --check.
     */
    public function diff(): AnsiblePlaybookInterface;

    /**
     * Sends extra variables to Ansible. The $extraVars parameter can be one of the following.
     *
     * ## Array
     * If an array is passed, it must contain the [ 'key' => 'value' ] pairs of the variables.
     *
     * Example:
     * ```php
     * $ansible = new Ansible()->playbook()->extraVars(['path' => 'some/path']);
     * ```
     *
     * ## File
     * As Ansible also supports extra vars loaded from an YML file, you can also pass a file path.
     *
     * Example:
     * ```php
     * $ansible = new Ansible()->playbook()->extraVars('/path/to/extra/vars.yml');
     * ```
     *
     * ## String
     * You can also pass the raw extra vars string directly.
     *
     * Example:
     * ```php
     * $ansible = new Ansible()->playbook()->extraVars('path=/some/path');
     * ```
     */
    public function extraVars(string|array $extraVars = ''): AnsiblePlaybookInterface;

    /**
     * clear the fact cache
     */
    public function flushCache(): AnsiblePlaybookInterface;

    /**
     * Run handlers even if a task fails.
     */
    public function forceHandlers(): AnsiblePlaybookInterface;

    /**
     * Specify number of parallel processes to use (default=5).
     */
    public function forks(int $forks = 5): AnsiblePlaybookInterface;

    /**
     * Show help message and exit.
     */
    public function help(): AnsiblePlaybookInterface;

    /**
     * Specify inventory host file (default=/etc/ansible/hosts).
     */
    public function inventoryFile(string $inventory = '/etc/ansible/hosts'): AnsiblePlaybookInterface;

    /**
     * Specify inventory host list manually.
     * Example:
     *
     * ```php
     * $ansible = new Ansible()->playbook()->inventory(['localhost', 'host1.example.com']);
     * ```
     */
    public function inventory(array $hosts = []): AnsiblePlaybookInterface;

    /**
     * Further limit selected hosts to an additional pattern.
     */
    public function limit(string|array $subset = ''): AnsiblePlaybookInterface;

    /**
     * Outputs a list of matching hosts; does not execute anything else.
     */
    public function listHosts(): AnsiblePlaybookInterface;

    /**
     * List all tasks that would be executed.
     */
    public function listTasks(): AnsiblePlaybookInterface;

    /**
     * Specify path(s) to module library (default=/usr/share/ansible/).
     */
    public function modulePath(array $path = ['/usr/share/ansible/']): AnsiblePlaybookInterface;

    /**
     * the new vault identity to use for rekey
     */
    public function newVaultId(string $vaultId): AnsiblePlaybookInterface;

    /**
     * new vault password file for rekey
     */
    public function newVaultPasswordFile(string $passwordFile): AnsiblePlaybookInterface;

    /**
     * Disable cowsay
     */
    public function noCows(): AnsiblePlaybookInterface;

    /**
     * Disable console colors
     */
    public function colors(bool $colors = true): AnsiblePlaybookInterface;

    /**
     * Enable/Disable Json Output
     */
    public function json(): AnsiblePlaybookInterface;

    /**
     * Use this file to authenticate the connection.
     */
    public function privateKey(string $file): AnsiblePlaybookInterface;

    /**
     * Only run plays and tasks whose tags do not match these values.
     */
    public function skipTags(string|array $tags = ''): AnsiblePlaybookInterface;

    /**
     * Start the playbook at the task matching this name.
     */
    public function startAtTask(string $task): AnsiblePlaybookInterface;

    /**
     * One-step-at-a-time: confirm each task before running.
     */
    public function step(): AnsiblePlaybookInterface;

    /**
     * Run operations with su.
     */
    public function su(): AnsiblePlaybookInterface;

    /**
     * Run operations with su as this user (default=root).
     */
    public function suUser(string $user = 'root'): AnsiblePlaybookInterface;

    /**
     * specify extra arguments to pass to scp only (e.g. -l)
     */
    public function scpExtraArgs(string|array $scpExtraArgs): AnsiblePlaybookInterface;

    /**
     * specify extra arguments to pass to sftp only (e.g. -f, -l)
     */
    public function sftpExtraArgs(string|array $sftpExtraArgs): AnsiblePlaybookInterface;

    /**
     * specify common arguments to pass to sftp/scp/ssh (e.g. ProxyCommand)
     */
    public function sshCommonArgs(string|array $sshArgs): AnsiblePlaybookInterface;

    /**
     * specify extra arguments to pass to ssh only (e.g. -R)
     */
    public function sshExtraArgs(string|array $extraArgs): AnsiblePlaybookInterface;

    /**
     * Ansible SSH pipelining option
     * https://docs.ansible.com/ansible/latest/reference_appendices/config.html#ansible-pipelining
     **/
    public function sshPipelining(bool $enable = false): AnsiblePlaybookInterface;

    /**
     * Perform a syntax check on the playbook, but do not execute it.
     */
    public function syntaxCheck(): AnsiblePlaybookInterface;

    /**
     * Only run plays and tasks tagged with these values.
     */
    public function tags(string|array $tags): AnsiblePlaybookInterface;

    /**
     * Override the SSH timeout in seconds (default=10).
     */
    public function timeout(int $timeout = 10): AnsiblePlaybookInterface;

    /**
     * Connect as this user.
     */
    public function user(string $user): AnsiblePlaybookInterface;

    /**
     * the vault identity to use
     */
    public function vaultId(string $vaultId): AnsiblePlaybookInterface;

    /**
     * Vault password file.
     */
    public function vaultPasswordFile(string $file): AnsiblePlaybookInterface;

    /**
     * Verbose mode (vvv for more, vvvv to enable connection debugging).
     */
    public function verbose(string $verbose = 'v'): AnsiblePlaybookInterface;

    /**
     * Show program's version number and exit.
     */
    public function version(): AnsiblePlaybookInterface;

    /**
     * Let you specify your custom roles path.
     * Example:
     * ```php
     * $ansible = new Ansible()->playbook()->rolesPath('/path/to/your/roles');
     * ```
     */
    public function rolesPath(string $path): AnsiblePlaybookInterface;

    /**
     * Enables or disables the host's SSH key checking.
     */
    public function hostKeyChecking(bool $enable = true): AnsiblePlaybookInterface;
}
