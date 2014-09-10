<?php

namespace phptests\User\Entity;

use phptests\User\UserInterface;


class UserTest extends \PHPTests_TestCase
{
    /**
     * @test
     */
    public function NewInstance_NotEmpty()
    {
        $user = new User();

        $this->assertNotEmpty($user);

        $this->assertInstanceOf('phptests\User\Entity\User', $user);
        $this->assertInstanceOf('phptests\User\UserInterface', $user);
    }
}
