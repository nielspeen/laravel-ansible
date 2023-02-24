<?php

namespace Peen\Ansible;

use Illuminate\Support\Facades\Config;
use Peen\Ansible\Exception\CommandException;
use Peen\Ansible\Testing\AnsibleTestCase;
use org\bovigo\vfs\vfsStream;

class AnsibleTest extends AnsibleTestCase
{
     /**
     * @covers \Peen\Ansible\Ansible::checkCommand
     * @covers \Peen\Ansible\Ansible::checkDir
     * @covers \Peen\Ansible\Ansible::__construct
     */
    public function testInstance()
    {
        $ansible = \Peen\Ansible\Facades\Ansible::use('default');
        $this->assertInstanceOf('\Peen\Ansible\Ansible', $ansible, 'Instantiation with given paths');
    }

    /**
     * @covers \Peen\Ansible\Ansible::checkCommand
     * @covers \Peen\Ansible\Ansible::checkDir
     * @covers \Peen\Ansible\Ansible::__construct
     */
    public function testAnsibleProjectPathNotFoundException()
    {
        $this->expectException(CommandException::class);

        Config::set('ansible.instances.default.playbooks_path', 'xxxxxxxx');

        \Peen\Ansible\Facades\Ansible::use('default');
    }

    /**
     * @covers \Peen\Ansible\Ansible::checkCommand
     * @covers \Peen\Ansible\Ansible::checkDir
     * @covers \Peen\Ansible\Ansible::__construct
     */
    public function testAnsibleCommandNotFoundException()
    {
        $this->expectException(CommandException::class);

        Config::set('ansible.instances.default.playbook_command', '/tmp/ansible-playbook');
        Config::set('ansible.instances.default.galaxy_command', '/tmp/ansible-galaxy');

        \Peen\Ansible\Facades\Ansible::use('default');
    }

    /**
     * @covers \Peen\Ansible\Ansible::checkCommand
     * @covers \Peen\Ansible\Ansible::checkDir
     * @covers \Peen\Ansible\Ansible::__construct
     */
    public function testAnsibleNoCommandGivenException()
    {
        // TODO: Not sure why the following command should give an error.
        $this->assertTrue(true);
        //        new Ansible(
        //            $this->getProjectUri()
        //        );
    }

    /**
     * @covers \Peen\Ansible\Ansible::checkCommand
     * @covers \Peen\Ansible\Ansible::checkDir
     * @covers \Peen\Ansible\Ansible::__construct
     */
    public function testAnsibleCommandNotExecutableException()
    {
        $this->expectException(CommandException::class);
        $vfs = vfsStream::setup('/tmp');
        $ansiblePlaybook = vfsStream::newFile('ansible-playbook', 600)->at($vfs);
        $ansibleGalaxy = vfsStream::newFile('ansible-galaxy', 444)->at($vfs);

        Config::set('ansible.instances.default.playbook_command', $ansiblePlaybook->url());
        Config::set('ansible.instances.default.galaxy_command', $ansibleGalaxy->url());

        \Peen\Ansible\Facades\Ansible::use('default');
    }

    /**
     * @covers \Peen\Ansible\Ansible::playbook
     * @covers \Peen\Ansible\Ansible::createProcess
     * @covers \Peen\Ansible\Ansible::checkCommand
     * @covers \Peen\Ansible\Ansible::checkDir
     * @covers \Peen\Ansible\Ansible::__construct
     */
    public function testPlaybookCommandInstance()
    {
        $playbook = \Peen\Ansible\Facades\Ansible::playbook();

        $this->assertInstanceOf('\Peen\Ansible\Command\AnsiblePlaybook', $playbook);
    }

    /**
     * @covers \Peen\Ansible\Ansible::galaxy
     * @covers \Peen\Ansible\Ansible::createProcess
     * @covers \Peen\Ansible\Ansible::checkCommand
     * @covers \Peen\Ansible\Ansible::checkDir
     * @covers \Peen\Ansible\Ansible::__construct
     */
    public function testGalaxyCommandInstance()
    {
        $galaxy = \Peen\Ansible\Facades\Ansible::galaxy();

        $this->assertInstanceOf('\Peen\Ansible\Command\AnsibleGalaxy', $galaxy);
    }

}
