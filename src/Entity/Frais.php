<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FraisRepository")
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
   * @ORM\Column(type="string")
   * @Assert\File(
   *     mimeTypes = {"application/pdf", "application/x-pdf"},
   *     mimeTypesMessage = "Le fichier selectionnée n'est pas un PDF"
   * )
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

    public function getJustificatif()
    {
        return $this->justificatif;
    }

    public function setJustificatif($justificatif)
    {
        $this->justificatif = $justificatif;

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
}
