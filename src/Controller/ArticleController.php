<?php

namespace App\Controller;

use App\ApiResource\detailApi_article;
use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{

	#[Route('', name: 'app_article')]
    public function index( ): Response
    {
        return $this->render( 'Article/show.html.twig');
    }

	#[Route('/{id}/detail_article', name: 'app_detail_article')]
	public function showDetails( Articles $id ): Response
	{
		return $this->render('article/detail.html.twig', ['article' => $id]);
	}

}
