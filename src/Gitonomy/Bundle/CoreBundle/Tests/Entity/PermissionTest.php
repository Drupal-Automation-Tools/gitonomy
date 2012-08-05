<?php

namespace Gitonomy\Bundle\CoreBundle\Tests\Entity;

use Gitonomy\Bundle\CoreBundle\Entity\Permission;

class PermissionTest extends \PHPUnit_Framework_TestCase
{
    public function testInstanciation()
    {
        $permission = new Permission('Name');

        $this->assertFalse($permission->isGlobal(), "Permission is not global by default");
        $this->assertEquals('Name', $permission->getName(), 'Name getter');

        $permission = new Permission('Name', true);

        $this->assertTrue($permission->isGlobal());
        $this->assertEquals('Name', $permission->getName(), 'Name getter');
    }
}
