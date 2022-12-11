<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class hashPasswordUserService
{
	public function __construct(private readonly UserPasswordHasherInterface $hasher) {}

	public function hashPasswordUserRegister( User $user, Request $request ): void
	{
		$plainText = $request->get('data')->getPlainText();
		$pass = $this->hasher->hashPassword($user, $plainText);
		$user->setPassword($pass)
			->setRoles(['ROLE_USER']);
	}

}