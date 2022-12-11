<?php

namespace App\ApiResource;

use App\Entity\User;
use App\Services\hashPasswordUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RegistrationApi extends AbstractController
{
	public function __invoke(User $data, Request $request, hashPasswordUserService $passwordUserService): User
	{
		$passwordUserService->hashPasswordUserRegister($data, $request);
		return $data;
	}
}