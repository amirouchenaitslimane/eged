<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

  /**
   * One product has many features. This is the inverse side.
   * @ORM\OneToMany(targetEntity="Facture", mappedBy="client")
   */
    private $factures;
public function __construct()
{
  $this->factures = new ArrayCollection();
}

  public function __toString()
  {
    return $this->nom;
  }

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

    /**
     * @return Collection|Facture[]
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setClient($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->contains($facture)) {
            $this->factures->removeElement($facture);
            // set the owning side to null (unless already changed)
            if ($facture->getClient() === $this) {
                $facture->setClient(null);
            }
        }

        return $this;
    }


}
