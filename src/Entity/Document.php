<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 * @Vich\Uploadable
 */
class Document
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
  /**
   * @var
   * @ORM\Column(type="string")
   */
    private $intitule;
  /**
   * @ORM\Column(type="date")
   */
    private $date;
  /**
   * @ORM\Column(type="string")
   */
    private $type;
  /**
   * @ORM\Column(type="string")
   */
    private $fichier;
  /**
   * @ORM\Column(type="datetime",nullable=true)
   */
    private $created_at;
  /**
   * @ORM\Column(type="datetime",nullable=true)
   */
    private $updated_at;
  /**
   * @var File
   * @Vich\UploadableField(mapping="document", fileNameProperty="fichier")
   *
   * @Assert\File(mimeTypes={ "application/pdf" })
   */
    private $file;

    const TYPE = [
      'URSSAF'=>'URSSAF',
      'CIPAV'=>'CIPAV',
      'RSI'=>'RSI',
      'Assurance_RP'=>'Assurance RP',
      'Compte-Pro'=>'Compte Pro',
      'Administratif'=>'Administratif'
    ];

public function __construct()
{
  $this->created_at = new \DateTime('now');

}

  public function getId(): ?int
    {
        return $this->id;
    }

  public function getIntitule(): ?string
  {
      return $this->intitule;
  }

  public function setIntitule(string $intitule): self
  {
      $this->intitule = $intitule;

      return $this;
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

  public function getType(): ?string
  {
      return $this->type;
  }

  public function setType(string $type): self
  {
      $this->type = $type;

      return $this;
  }

  public function getFichier(): ?string
  {
      return $this->fichier;
  }

  public function setFichier($fichier)
  {
      $this->fichier = $fichier;

      return $this;
  }

  public function getCreatedAt(): ?\DateTimeInterface
  {
      return $this->created_at;
  }

  public function setCreatedAt(\DateTimeInterface $created_at): self
  {
      $this->created_at = $created_at;

      return $this;
  }

  public function getUpdatedAt(): ?\DateTimeInterface
  {
      return $this->updated_at;
  }

  public function setUpdatedAt(\DateTimeInterface $updated_at): self
  {
      $this->updated_at = $updated_at;

      return $this;
  }

  /**
   * @param File|null $file
   * @throws \Exception
   */
  public function setFile(File $file = null)
  {
    $this->file = $file;

    if (null !== $file) {
      // It is required that at least one field changes if you are using doctrine
      // otherwise the event listeners won't be called and the file is lost
      $this->updated_at = new \DateTimeImmutable();
    }

  }

  public function getFile()
  {
    return $this->file;
  }
}
