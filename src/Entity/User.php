<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    private $plainPassword;
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;
    /**
     * @ORM\Column(type="string", nullable=true, length=180)
     */
    private $hobby=null;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $profile_photo="icons/img/profile.png";
    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    private $token=null;
    /**
     * @ORM\Column(type="integer")
     */
    private $views=0;
    /**
     * @ORM\Column(type="string",length=255)
    */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="nickname", orphanRemoval=true)
     */
    private $publications;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
    }
    public function getHobby() : string {
        if($this->hobby == null ){
            return "No information";
        }
        return $this->hobby;
    }
    public function sethobby(string $hobby):self{
        $this->hobby = $hobby;
        return $this;
    }
    public function getName() : string {
        
        return $this->name;
    }
    public function setName(string $hobby):self{
        $this->name = $hobby;
        return $this;
    }
    public function getPlainPassword() {
        return $this->plainPassword;
    }
    public function setPlainPassword(string $plp) {
        $this->plainPassword = $plp;
    }
    public function getToken() : string {
        return $this->token;
    }
    public function setToken(string $hobby):self{
        $this->token = $hobby;
        return $this;
    }
    public function getViews() : string {
        return $this->views;
    }
    public function updateViews(){
         $this->views++;
    }
    public function getPhoto():string{
        return $this->profile_photo;
    }
    public function setPhoto(string $newFiledistance):self {
        $this->profile_photo = $newFiledistance;
        return $this;
    }
    public function getEmail() : string {
        return $this->email;
    }
    public function setEmail(string $email):self{
        $this->email = $email;
        return $this;
    }
    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
    
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->id;
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
     * @see UserInterface
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Post $publication): self
    {
        if (!$this->publications->contains($publication)) {
            $this->publications[] = $publication;
            $publication->setNickname($this);
        }

        return $this;
    }

    public function removePublication(Post $publication): self
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getNickname() === $this) {
                $publication->setNickname(null);
            }
        }

        return $this;
    }
}
