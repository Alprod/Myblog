<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\RegisterUserController;
use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
#[ApiResource(
	operations: [
        new GetCollection(
            uriTemplate: '/articles/all',
            normalizationContext: ['groups' => 'all_articles'],
            name: 'api-all-articles'),
        new Get(
            uriTemplate : '/articles/{id}/details_article',
            requirements : [ 'id' => '\d+'],
            normalizationContext : [ 'groups' => 'details_article'],
            name : 'api-details-article'),
        new Post(
            uriTemplate: '/articles/new',
            denormalizationContext: [ 'groups' => 'add_new_articles'],
            name: 'api-register-articles' ),
        new Patch(
            uriTemplate: '/articles/{id}/edit',
            requirements: ['id' => '\d+'],
            denormalizationContext: ['groups' => 'update_articles'],
            name: 'api-update-articles'),
        new Delete(
            uriTemplate: '/articles/{id}/delete',
            requirements: ['id' => '\d+'],
            normalizationContext: ['groups' => 'delete_articles'],
            name: 'api-delete-articles')
    ]
)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
		'all_articles',
		'details_article',
		'delete_articles',
		'all', 'details',
		'all_images',
		'details_image'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
		'all_articles',
		'details_article',
		'update_articles',
		'add_new_articles',
		'all', 'details',
		'all_images',
		'details_image'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups([
		'all_articles',
		'details_article',
		'update_articles',
		'add_new_articles',
		'all', 'details'])]
    private ?string $content = null;

    #[ORM\Column]
    #[Groups([
	    'all_articles',
	    'details_article',
	    'update_articles',
		'add_new_articles',
	    'all', 'details'])]
    private ?bool $isPublished = null;

    #[ORM\Column]
    #[Groups([
	    'all_articles',
	    'details_article',
	    'update_articles',
	    'add_new_articles',
	    'all', 'details'])]
    private ?bool $isPublic = null;

    #[ORM\Column]
    #[Groups([
	    'all_articles',
	    'details_article',
	    'add_new_articles',
	    'all', 'details'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
	    'all_articles',
	    'details_article',
	    'update_articles',
	    'add_new_articles',
	    ])]
    private ?string $coverImg = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[Groups([
	    'all_articles',
	    'details_article',
	    'add_new_articles',
	    ])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'articles', targetEntity: Images::class)]
    #[Groups([
	    'all_articles',
	    'details_article',
    ])]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function isIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;

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

    public function getCoverImg(): ?string
    {
        return $this->coverImg;
    }

    public function setCoverImg(?string $coverImg): self
    {
        $this->coverImg = $coverImg;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setArticles($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getArticles() === $this) {
                $image->setArticles(null);
            }
        }

        return $this;
    }
}
