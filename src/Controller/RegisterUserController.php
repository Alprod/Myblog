<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class RegisterUserController extends AbstractController
{
	#[Route('/registration', name: 'app_registration')]
	public function register(): Response {
		return $this->render( 'admin/registration.html.twig' );
	}
}
