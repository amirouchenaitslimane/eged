<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FraisRepository")
 * @Vich\Uploadable
 */
class Frais
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
  /**
   * @ORM\Column(type="date",nullable=false)
   */
    private $date;
  /**
   * @ORM\Column(type="string")
   */
    private $libelle;
  /**
   * @ORM\Column(type="string")
   */
    private $type;
  /**
   * @ORM\Column(type="decimal")
   */
    private $montant_ttc;
  /**
   * @ORM\Column(type="decimal")
   */
    private $montant_ht;
  /**
   * @var File
   * @Vich\UploadableField(mapping="ged", fileNameProperty="justificatif")
   */
    private $fichier;
  /**
   * @ORM\Column(type="string")
   *
   */
    private $justificatif;
  /**
   * @ORM\Column(type="decimal")
   */
    private $taxe;
  /**
   * @ORM\Column(type="string")
   */
    private $etat;
  /**
   * @ORM\Column(type="datetime",nullable=true)
   *
   * @var \DateTime
   */
  private $updatedAt;

    public function __construct()
    {
      $this->etat = "Brouillon";
    }

  public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMontantTtc()
    {
        return $this->montant_ttc;
    }

    public function setMontantTtc($montant_ttc): self
    {
        $this->montant_ttc = $montant_ttc;

        return $this;
    }

    public function getMontantHt()
    {
        return $this->montant_ht;
    }

    public function setMontantHt($montant_ht): self
    {
        $this->montant_ht = $montant_ht;

        return $this;
    }





    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getTaxe()
    {
        return $this->taxe;
    }

    public function setTaxe($taxe): self
    {
        $this->taxe = $taxe;

        return $this;
    }

  public function setFichier(File $fichier = null)
  {
    $this->fichier = $fichier;

    if (null !== $fichier) {
      // It is required that at least one field changes if you are using doctrine
      // otherwise the event listeners won't be called and the file is lost
      $this->updatedAt = new \DateTimeImmutable();
    }

  }

  public function getFichier()
  {
    return $this->fichier;
  }

  public function getJustificatif()
  {
    return $this->justificatif;
  }

  public function setJustificatif($justificatif)
  {
    $this->justificatif = $justificatif;

    return $this;
  }

  public function getUpdatedAt(): ?\DateTimeInterface
  {
      return $this->updatedAt;
  }

  public function setUpdatedAt(\DateTimeInterface $updatedAt): self
  {
      $this->updatedAt = $updatedAt;

      return $this;
  }
}
