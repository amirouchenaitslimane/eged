<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CraRepository")
 */
class Cra
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
   *
   * @ORM\ManyToOne(targetEntity="Client", inversedBy="cras")
   * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
   */
    private $client;
  /**
   * @ORM\Column(type="string",nullable=false)
   */
    private $journee;


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

    public function getJournee(): ?string
    {
        return $this->journee;
    }

    public function setJournee(string $journee): self
    {
        $this->journee = $journee;

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
}
