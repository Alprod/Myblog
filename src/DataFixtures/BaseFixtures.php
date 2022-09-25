<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixtures extends Fixture
{

	/** @var ObjectManager */
	private ObjectManager $manager;

	/** @var Generator */
	protected Generator $faker;

	private array $referencesIndex = [];

	abstract protected function loadData(ObjectManager $manager);

	/**
	 * @inheritDoc
	 */
	public function load( ObjectManager $manager ) : void
	{
		$this->manager = $manager;
		$this->faker = Factory::create('fr_FR');
		$this->loadData($manager);
	}

	protected function createMany(string $className, int $count, callable $factory): void
	{
		for ($i = 1; $i <= $count; $i++) {
			$entity = new $className();
			$factory($entity, $i);

			$this->manager->persist($entity);
			$this->addReference($className.'_'.$i, $entity);
		}

	}

	protected function getRandomReference(string $className): object
	{
		if (!isset($this->referencesIndex[$className])) {
			$this->referencesIndex[$className] = [];
			foreach ($this->referenceRepository->getReferences() as $key => $ref) {
				if ( str_starts_with( $key, $className . '_' ) ) {
					$this->referencesIndex[$className][] = $key;
				}
			}
		}
		if (empty($this->referencesIndex[$className])) {
			throw new \RuntimeException(sprintf('Impossible de trouver des références pour la classe "%s"', $className));
		}
		$randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$className]);
		return $this->getReference($randomReferenceKey);
	}
}