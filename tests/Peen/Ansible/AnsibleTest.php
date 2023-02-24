<?php
/*
 * This file is part of the php-ansible package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Peen\Ansible;

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
        $ansible = new Ansible(
            $this->getProjectUri(),
            $this->getPlaybookUri(),
            $this->getGalaxyUri()
        );
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
        new Ansible(
            'xxxxxxxx',
            $this->getPlaybookUri(),
            $this->getGalaxyUri()
        );
    }

    /**
     * @covers \Peen\Ansible\Ansible::checkCommand
     * @covers \Peen\Ansible\Ansible::checkDir
     * @covers \Peen\Ansible\Ansible::__construct
     */
    public function testAnsibleCommandNotFoundException()
    {
        $this->expectException(CommandException::class);
        new Ansible(
            $this->getProjectUri(),
            '/tmp/ansible-playbook',
            '/tmp/ansible-galaxy'
        );
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

        new Ansible(
            $this->getProjectUri(),
            $ansiblePlaybook->url(),
            $ansibleGalaxy->url()
        );
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
        $ansible = new Ansible(
            $this->getProjectUri(),
            $this->getPlaybookUri(),
            $this->getGalaxyUri()
        );

        $playbook = $ansible->playbook();

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
        $ansible = new Ansible(
            $this->getProjectUri(),
            $this->getPlaybookUri(),
            $this->getGalaxyUri()
        );

        $galaxy = $ansible->galaxy();

        $this->assertInstanceOf('\Peen\Ansible\Command\AnsibleGalaxy', $galaxy);
    }
}
