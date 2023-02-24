<?php

declare(strict_types=1);

namespace Peen\Ansible\Command;

final class AnsibleGalaxy extends AbstractAnsibleCommand implements AnsibleGalaxyInterface
{
    /**
     * Executes a command process.
     * Returns either exitcode or string output if no callback is given.
     */
    public function execute(?callable $callback = null): int|string
    {
        return $this->runProcess($callback);
    }

    /**
     * Initialize a new role with base structure.
     */
    public function init(string $roleName): AnsibleGalaxyInterface
    {
        $this
            ->addBaseOption('init')
            ->addBaseOption($roleName);

        return $this;
    }

    public function info(string $role, string $version = ''): AnsibleGalaxyInterface
    {
        if ('' !== $version) {
            $role = $role . ',' . $version;
        }

        $this
            ->addBaseOption('info')
            ->addBaseOption($role);

        return $this;
    }

    /**
     * Install packages.
     *
     * If you are unsure whether the role(s) is already installed,
     * either check first or use the "force" option.
     */
    public function install(string|array $roles = ''): AnsibleGalaxyInterface
    {
        $roles = $this->checkParam($roles, ' ');

        $this->addBaseOption('install');

        if ('' !== $roles) {
            $this->addBaseOption($roles);
        }

        return $this;
    }

    /**
     * Get a list of installed modules.
     */
    public function modulelist(string $roleName = ''): AnsibleGalaxyInterface
    {
        $this->addBaseOption('list');

        if ('' !== $roleName) {
            $this->addBaseOption($roleName);
        }

        return $this;
    }

    /**
     * Add package(s)
     */
    public function remove(string|array $roles = ''): AnsibleGalaxyInterface
    {
        $roles = $this->checkParam($roles, ' ');

        $this
            ->addBaseOption('remove')
            ->addBaseOption($roles);

        return $this;
    }

    /**
     * Show general or specific help.
     */
    public function help(): AnsibleGalaxyInterface
    {
        $this->addParameter('--help');

        return $this;
    }

    /**
     * The path in which the skeleton role will be created.
     * The default is the current working directory.
     */
    public function initPath(string $path = ''): AnsibleGalaxyInterface
    {
        $this->addOption('--init-path', $path);

        return $this;
    }

    /**
     * Don't query the galaxy API when creating roles.
     */
    public function offline(): AnsibleGalaxyInterface
    {
        $this->addParameter('--offline');

        return $this;
    }

    /**
     * The API server destination.
     */
    public function server(string $apiServer): AnsibleGalaxyInterface
    {
        $this->addOption('--server', $apiServer);

        return $this;
    }

    /**
     * Force overwriting an existing role.
     */
    public function force(): AnsibleGalaxyInterface
    {
        $this->addParameter('--force');

        return $this;
    }

    /**
     * A file containing a list of roles to be imported.
     */
    public function roleFile(string $roleFile): AnsibleGalaxyInterface
    {
        $this->addOption('--role-file', $roleFile);

        return $this;
    }

    /**
     * The path to the directory containing your roles.
     *
     * The default is the roles_path configured in your
     * ansible.cfg file (/etc/ansible/roles if not configured).
     */
    public function rolesPath(string $rolesPath): AnsibleGalaxyInterface
    {
        $this->addOption('--roles-path', $rolesPath);

        return $this;
    }

    /**
     * Ignore errors and continue with the next specified role.
     */
    public function ignoreErrors(): AnsibleGalaxyInterface
    {
        $this->addParameter('--ignore-errors');

        return $this;
    }

    /**
     * Don't download roles listed as dependencies.
     */
    public function noDeps(): AnsibleGalaxyInterface
    {
        $this->addParameter('--no-deps');

        return $this;
    }

    /**
     * Get parameter string which will be used to call ansible.
     */
    public function getCommandlineArguments(bool $asArray = true): string|array
    {
        return $this->prepareArguments($asArray);
    }
}
