<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersService
{

	public function __construct(
		private readonly UserPasswordHasherInterface $hasher,
	) {}

	public function addUsers( User $user, Request $request): void
	{
		$plainPassword = $request->get('data')->getPassword();
		$pass = $this->hasher->hashPassword($user, $plainPassword);

		$user->setPassword($pass)
		     ->setRoles(['ROLE_USER']);
	}

}