<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
	private $hasher;

	public function __construct(UserPasswordHasherInterface $hasher)
	{
		$this->hasher = $hasher;
	}

	/**
	 * @inheritDoc
	 */
	public function load( ObjectManager $manager )
	{
		$admin = new User();
		$admin->setPlainText('Admin_001');
		$pass = $this->hasher->hashPassword($admin, $admin->getPlainText());

		$admin->setFirstname('admin')
			->setLastname('user')
			->setPassword($pass)
			->setAvatar('pas d\'avatar')
			->setEmail('admin@demo.fr')
			->setPseudo('Adminer')
			->setRoles(['ROLE_ADMIN']);
		$manager->persist($admin);
		$manager->flush();
	}
}