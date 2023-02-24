<?php

namespace Peen\Ansible\Command;

interface AnsibleGalaxyInterface extends AnsibleCommandInterface
{
    /**
     * Initialize a new role with base structure.
     */
    public function init(string $roleName): AnsibleGalaxyInterface;

    public function info(string $role, string $version = ''): AnsibleGalaxyInterface;

    /**
     * Install packages.
     *
     * If you are unsure whether the role(s) is already installed,
     * either check first or use the "force" option.
     */
    public function install(string|array $roles = ''): AnsibleGalaxyInterface;

    /**
     * Get a list of installed modules.
     */
    public function modulelist(string $roleName = ''): AnsibleGalaxyInterface;

    /**
     * Add package(s)
     */
    public function remove(string|array $roles = ''): AnsibleGalaxyInterface;

    /**
     * Show general or specific help.
     */
    public function help(): AnsibleGalaxyInterface;

    /**
     * The path in which the skeleton role will be created.
     * The default is the current working directory.
     */
    public function initPath(string $path = ''): AnsibleGalaxyInterface;

    /**
     * Don't query the galaxy API when creating roles.
     */
    public function offline(): AnsibleGalaxyInterface;

    /**
     * The API server destination.
     */
    public function server(string $apiServer): AnsibleGalaxyInterface;

    /**
     * Force overwriting an existing role.
     */
    public function force(): AnsibleGalaxyInterface;

    /**
     * A file containing a list of roles to be imported.
     */
    public function roleFile(string $roleFile): AnsibleGalaxyInterface;

    /**
     * The path to the directory containing your roles.
     *
     * The default is the roles_path configured in your
     * ansible.cfg file (/etc/ansible/roles if not configured).
     *
     * @param string $rolesPath
     * @return AnsibleGalaxyInterface
     */
    public function rolesPath(string $rolesPath): AnsibleGalaxyInterface;

    /**
     * Ignore errors and continue with the next specified role.
     *
     * @return AnsibleGalaxyInterface
     */
    public function ignoreErrors(): AnsibleGalaxyInterface;

    /**
     * Don't download roles listed as dependencies.
     *
     * @return AnsibleGalaxyInterface
     */
    public function noDeps(): AnsibleGalaxyInterface;
}
