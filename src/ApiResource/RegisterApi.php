<?php

namespace App\ApiResource;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterApi extends AbstractController
{
	public function __construct( private readonly UserPasswordHasherInterface $hasher) {}

	public function hashPasswordUserRegister( User $user, Request $request): void
	{
		$plainPassword = $request->get('data')->getPlainText();

		$pass = $this->hasher->hashPassword($user, $plainPassword);
		$user->setPassword($pass)
		     ->setRoles(['ROLE_USER']);

		$this->json(['success' => 'Bienvenu à toi'. $user->getPseudo()], 200);
	}
}