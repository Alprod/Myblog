<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\RegisterUserController;
use App\Repository\UserRepository;
use App\Validator\ContainsPassword;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations : [
		new GetCollection(
			uriTemplate: '/all',
			normalizationContext: ['groups' => 'all'],
			name: 'api-all-users'),
		new Get(
			uriTemplate : '/{id}/details',
			requirements : [ 'id' => '\d+'],
			normalizationContext : [ 'groups' => 'details'],
			name : 'api-details-users'),
		new Post(
			uriTemplate: '/register',
			controller : RegisterUserController::class,
			denormalizationContext : [ 'groups' => 'register'],
			name : 'api-register-users' ),
		new Patch(
			uriTemplate: '/{id}/update',
			requirements: ['id' => '\d+'],
			denormalizationContext: ['groups' => 'update'],
			name: 'api-update-user'),
		new Delete(
			uriTemplate: '/{id}/delete',
			requirements: ['id' => '\d+'],
			normalizationContext: ['groups' => 'delete'],
			name: 'api-delete-user')
			],
	routePrefix: '/user'
)]
#[UniqueEntity(
	fields: 'email' ,
	message: 'Désolé mais il semblerait que cette adresse e-mail soit déjà utiliser'
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['details',
              'all',
              'delete',
              'add_new_articles'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[NotBlank([
		'message' => 'Désoler mais {{ label }} doit être indiquer'
    ])]
    #[Email( message : '{{ value }} n\'est pas un email valide' )]
    #[Groups(['register',
              'details',
              'update',
              'all'])]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private string $password;

	#[Regex(
		pattern: '/^\S*(?=\S{8,})(?=\S*[\W+_])(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/i',
		message: 'Votre mot passe doit contenir 8 caractères, 1 majuscule, 1 nombre, 1 caractère spécial (exemple : #@&_-?.)',
		match: true
	)]
	#[NotBlank(
		message: 'Désoler mais vous devez indiquer une valeur'
	)]
	#[Groups(['register', 'update'])]
	private string $plainText;


    #[ORM\Column(length: 255)]
    #[Groups(['register','details', 'update', 'all'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['register','details', 'update', 'all'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['register','details', 'update','all'])]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['register','details','all'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['details', 'update'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['register', 'details', 'update','all'])]
    private ?string $avatar = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Articles::class)]
    #[Groups(['all', 'details'])]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

	/**
	 * @return string
	 */
	public function getPlainText(): string {
		return $this->plainText;
	}

	/**
	 * @param string  $plainText
	 */
	public function setPlainText( string $plainText ): void {
		$this->plainText = $plainText;
	}

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

	#[Groups(['details', 'all', 'all_articles','details_article'])]
    public function getFullname(): string
    {
        return $this->getFirstname().' '.$this->getLastname();
    }

	#[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime('now');
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }
}
