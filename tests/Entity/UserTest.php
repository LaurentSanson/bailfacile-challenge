<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Tests\AppTestCase;
use App\Tests\Fixtures\UserBuilder;

class UserTest extends AppTestCase
{
    /**
     * @test
     */
    public function testUserIsCreated()
    {
        /** @var User $user */
        $user = UserBuilder::for($this)->any();

        self::assertNotNull($user->getId());
    }
}
