<?php

namespace App\Controller;

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

	private EntityManagerInterface $em;

	public function __construct( EntityManagerInterface $em )
	{
		$this->em = $em;
	}

	#[Route('/', name: 'app_article')]
    public function index( ): Response
    {
		$article = $this->em->getRepository(Articles::class);
        return $this->render( 'Article/show.html.twig', [
			'articles' => $article->findAll()
        ]);
    }

}
