<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable=false)
     * @Assert\NotBlank(message="Le nom de client es obligatoire!")
     */
    private $nom;
  /**
   * @var string $addresse
   * @ORM\Column(type="string",nullable=false)
   * @Assert\NotBlank(message="L'adresse de client es obligatoire!")
   */
    private $addresse;
  /**
   * @var string $email
   * @ORM\Column(type="string",nullable=true)
   * @Assert\Email(
   *     message = "L'email '{{ value }}' n'est pas un email valide.",
   *     checkMX = true
   * )
   */
    private $email;
  /**
   * @var string $telephone
   * @ORM\Column(type="string",nullable=true)
   */
    private $telephone;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }


}
