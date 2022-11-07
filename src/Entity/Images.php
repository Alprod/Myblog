<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ImagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
#[ApiResource(
    routePrefix: '/image',
	operations: [
		new GetCollection(
			uriTemplate: '/all',
			normalizationContext: ['groups'=>'all_images'],
			name: 'api-all-images'
        ),
		new Get(
			uriTemplate: '/{id}/details_image',
			requirements: [ 'id' => '\d+' ],
			normalizationContext: ['groups' => 'details_image'],
			name: 'api-details-image'
		),
		new Post(
			uriTemplate: '/new',
			denormalizationContext: ['groups' => 'add_new_images'],
			name: 'api-add-new'
        ),
        new Patch(
            uriTemplate: '{id}/update',
            denormalizationContext: ['groups' => 'update_image'],
            name: 'api-update-image'
        )
	]
)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['all_images', 'details_image'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[Groups([
		'all_images',
		'details_image',
        'update_image',
		'all_articles',
		'details_article'])]
    private array $images = [];

    #[ORM\Column(length: 255)]
    #[Groups([
	    'all_images',
	    'details_image',
        'update_image',
	    'all_articles',
	    'details_article'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups([
	    'all_images',
	    'details_image',
	    'all_articles',
	    'details_article'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[Groups([
	    'all_images',
	    'details_image',
        'update_image'])]
    private ?Articles $articles = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getArticles(): ?Articles
    {
        return $this->articles;
    }

    public function setArticles(?Articles $articles): self
    {
        $this->articles = $articles;

        return $this;
    }
}
