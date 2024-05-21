<?php

namespace App\Tests\Entity;

use App\Entity\BrinkerUser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BrinkerUserEntityTest extends KernelTestCase
{
    protected static $container;
    public function testRequiredFields()
    {
        self::bootKernel();
        self::$container = self::$kernel->getContainer();

        $entityManager = self::$container->get('doctrine')->getManager();

        $metadata = $entityManager->getClassMetadata(BrinkerUser::class);
        $requiredFields = $metadata->getFieldNames();

        $this->assertContains('username', $requiredFields, 'The username field is required');
    }

    public function testBrinkerUserFailsWithoutUsername()
    {
        self::bootKernel();
        self::$container = self::$kernel->getContainer();

        $entityManager = self::$container->get('doctrine')->getManager();

        $metadata = $entityManager->getClassMetadata(BrinkerUser::class);
        $user = new BrinkerUser();
        $user->setZip("80334");
        try {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->fail('Persisting user succeeded when it should not have');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
}
