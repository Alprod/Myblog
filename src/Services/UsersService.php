<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersService extends AbstractController
{

	public function __construct(
		private readonly UserPasswordHasherInterface $hasher,
	) {}

	public function addUsers( User $user, Request $request): JsonResponse
	{
		$plainPassword = $request->get('data')->getPassword();
		if($plainPassword){
			$pass = $this->hasher->hashPassword($user, $plainPassword);
			$user->setPassword($pass)
			     ->setRoles(['ROLE_USER']);
			return $this->json(['SUCCESS' => 'Bienvenu à toi'. $user->getPseudo()]);
		}

		return $this->json(['ERROR'=>'Veuillez indiquer un mot de passe']);
	}

}