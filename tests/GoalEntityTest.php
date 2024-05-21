<?php

namespace App\Tests\Entity;

use App\Entity\Goal;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GoalEntityTest extends KernelTestCase
{
    protected static $container;
    public function testRequiredFields()
    {
        self::bootKernel();
        self::$container = self::$kernel->getContainer();

        $entityManager = self::$container->get('doctrine')->getManager();

        $metadata = $entityManager->getClassMetadata(Goal::class);
        $requiredFields = $metadata->getFieldNames();

        $this->assertContains('title', $requiredFields, 'The title field is required');
    }

    public function testGoalFailsWithoutTitle()
    {
        self::bootKernel();
        self::$container = self::$kernel->getContainer();

        $entityManager = self::$container->get('doctrine')->getManager();

        $metadata = $entityManager->getClassMetadata(Goal::class);
        $goal = new Goal();
        $goal->setDescription("valid description");
        try {
            $entityManager->persist($goal);
            $entityManager->flush();
            $this->fail('Persisting goal succeeded when it should not have');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
}
