<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocieteRepository")
 */
class Societe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
  /**
   * @var string $nom raison social
   * @ORM\Column(type="string",nullable=false)
   * @Assert\NotBlank(message="Le nom de la sociéte est obligatoire!")
   */
    private $nom;
  /**
   * @ORM\Column(type="string",nullable=false)
   * @Assert\NotBlank(message="Le numero de siret est obligatoire!")
   */
    private $numero_siret;
  /**
   * @ORM\Column(type="string",nullable=false)
   * @Assert\NotBlank(message="La Tva est obligatoire!")
   */
    private $tva_intercomunaitaire ;
  /**
   * @ORM\Column(type="string",nullable=false)
   * @Assert\NotBlank(message="Le numero de telephone est obligatoire!")
   */
    private $telephone;
  /**
   * @ORM\Column(type="string",nullable=false)
   * @Assert\NotBlank(message="L'email  est obligatoire!")
   */
    private $email;

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



    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
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

    public function getNumeroSiret(): ?string
    {
        return $this->numero_siret;
    }

    public function setNumeroSiret(string $numero_siret): self
    {
        $this->numero_siret = $numero_siret;

        return $this;
    }

    public function getTvaIntercomunaitaire(): ?string
    {
        return $this->tva_intercomunaitaire;
    }

    public function setTvaIntercomunaitaire(string $tva_intercomunaitaire): self
    {
        $this->tva_intercomunaitaire = $tva_intercomunaitaire;

        return $this;
    }
}
