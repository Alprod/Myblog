<?php

namespace App\Controller;

use App\ApiResource\RegisterApi;
use App\Entity\User;
use App\Services\UsersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class RegisterUserController extends AbstractController
{

	public function __invoke(User $data ,Request $request, RegisterApi $registerApi): User
	{
		$registerApi->hashPasswordUserRegister($data, $request);
		return $data;
	}

}
