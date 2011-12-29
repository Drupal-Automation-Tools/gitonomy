<?php

namespace Gitonomy\Bundle\CoreBundle\Tests\Command;

use Gitonomy\Bundle\CoreBundle\Test\CommandTestCase;

class UserSshKeyCreateCommandTest extends CommandTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = self::createClient();
        $this->client->startIsolation();
    }

    public function tearDown()
    {
        $this->client->stopIsolation();
    }

    public function testSimpleCase()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, 'gitonomy:user-ssh-key-create "alice" foo bar');

        $this->assertEquals("The key named foo was successfully added to user alice!\n", $output);

        $em = $this->client->getKernel()->getContainer()->get('doctrine')->getEntityManager();

        $userSshKey = $em->getRepository('GitonomyCoreBundle:UserSshKey')->findOneBy(array(
            'title' => 'foo'
        ));

        $this->assertInstanceOf('Gitonomy\Bundle\CoreBundle\Entity\UserSshKey', $userSshKey);

        $this->assertEquals('alice', $userSshKey->getUser()->getUsername());
        $this->assertEquals('foo', $userSshKey->getTitle());
        $this->assertEquals('bar', $userSshKey->getContent());
    }

    public function testNonExistingUser()
    {
        list($statusCode ,$output) = $this->runCommand($this->client, 'gitonomy:user-ssh-key-create "foo" bar baz');

        $this->assertContains('User with username "foo" not found', $output);
    }
}
