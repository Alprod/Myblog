<?php

namespace App\ApiResource;

use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class detailApi_article extends AbstractController
{
	public function __invoke(Articles $data): Response
	{
		return $this->render('article/detail.html.twig', [
			'data' => $data
		]);
	}
}