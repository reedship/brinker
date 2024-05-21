<?php

namespace App\Tests;

use App\Entity\Goal;
use App\Entity\BrinkerUser;
use App\Controller\GoalController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;

class GoalControllerTest extends WebTestCase
{

    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
}
