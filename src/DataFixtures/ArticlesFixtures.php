<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticlesFixtures extends BaseFixtures implements DependentFixtureInterface
{

	protected function loadData( ObjectManager $manager )
	{
		$this->createMany(Articles::class, 15, function (Articles $articles, $index){

			$dateFaker = $this->faker->dateTimeBetween('-4 month', 'now');
			$immutDate = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s',$dateFaker->format('Y-m-d H:i:s'));

			$articles->setTitle($this->faker->sentence(3, true))
				->setContent($this->faker->realText(200))
				->setIsPublished($this->faker->boolean(50))
				->setIsPublic($this->faker->boolean(50))
				->setCreatedAt($immutDate)
				->setUser($this->getRandomReference(User::class));
			$this->setReference('articles_'.$index);
		});
		$manager->flush();
	}


	public function getDependencies(): array
	{
		return [
			UserFixtures::class,
			AdminFixtures::class
		];
	}
}