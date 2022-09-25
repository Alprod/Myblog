<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends BaseFixtures
{
	private UserPasswordHasherInterface $hasher;

	public function __construct(UserPasswordHasherInterface $hasher)
	{
		$this->hasher = $hasher;
	}

	protected function loadData( ObjectManager $manager ) {
		$this->createMany(User::class, 8, function (User $user, $index) {
			$pass = $this->hasher->hashPassword($user, 'password');
			$user->setFirstname($this->faker->firstName)
				->setLastname($this->faker->lastName)
				->setPseudo($this->faker->name)
				->setEmail($this->faker->email)
				->setRoles(['ROLE_USER'])
				->setAvatar('pas d\'avatar')
				->setPassword($pass);

			$this->setReference('users_'.$index, $user);
		});
		$manager->flush();
	}
}