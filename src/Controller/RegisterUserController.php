<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\UsersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterUserController extends AbstractController
{
	public function __construct(private UsersService $users) {}

	public function __invoke(User $data ,Request $request)
	{
		$this->users->addUsers($data, $request);
		return $data;
	}
}
