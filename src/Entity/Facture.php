<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Facture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

  /**
   *
   * @ORM\ManyToOne(targetEntity="Client", inversedBy="factures")
   * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
   */
    private $client;
  /**
   * @ORM\Column(type="date",nullable=false)
   */
    private $date;
  /**
   * @ORM\Column(type="date",nullable=false)
   */
    private $date_debut;
  /**
   * @ORM\Column(type="date",nullable=false)
   */
    private $date_fin;
  /**
   * @ORM\Column(type="string",nullable=false)
   */
    private $etat;
  /**
   * @ORM\Column(type="text",nullable=false)
   */
    private $designation;
  /**
   * @ORM\Column(type="float",nullable=false)
   */
    private $quantite;
  /**
   * @ORM\Column(type="float",nullable=false)
   */
    private $prix_unitaire;
    const TVA = 20;
  /**
   * @ORM\Column(type="float",nullable=true)
   */
    private $totalHt;
  /**
   * @ORM\Column(type="float",nullable=true)
   */
    private $totalTva;
  /**
   * @ORM\Column(type="float",nullable=true)
   */
    private $totalTtc;


    //Brouillons - Validée - Envoyée - Rejetée -  Encaissée
  const ETAT = [
    'brouillon'=>'Brouillon',
    'validee'=>'Validée',
    'envoyee'=>'Envoyée',
    'rejetee'=>'Rejetée',
    'encaissee'=>'Encaissée'
  ];
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

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

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(float $prix_unitaire): self
    {
        $this->prix_unitaire = $prix_unitaire;

        return $this;
    }

    public function getTotalHt(): ?float
    {
        return $this->totalHt;
    }
  /**
   * @ORM\PrePersist
   */
    public function setTotalHt()
    {
        $this->totalHt = $this->prix_unitaire * $this->quantite;

        return $this;
    }

    public function getTotalTva(): ?float
    {
        return $this->totalTva;
    }
  /**
   * @ORM\PrePersist
   */
    public function setTotalTva(): self
    {
      //(Total HT * 20)/100
        $this->totalTva = (($this->totalHt * self::TVA) / 100) ;

        return $this;
    }

    public function getTotalTtc()
    {
        return $this->totalTtc;
    }
  /**
   * @ORM\PrePersist
   */
    public function setTotalTtc( )
    {
      //= Total HT + Total TVA (non modifiable)
        $this->totalTtc = $this->totalHt + $this->totalTva;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function __clone()
    {
      $this->id = null;
    }
}
