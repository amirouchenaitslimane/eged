<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
  /**
   * @var string
   *
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
    private $nom;
  /**
   * @var string
   *
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
    private $prenom;
  /**
   * @var string
   *
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
    private $email;
  /**
   * @var string
   *
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
    private $username;
  /**
   * @var string
   *
   * @ORM\Column(type="string")
   *
   */
    private $password;
    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $roles = [];
  /**
   * @var bool
   * @ORM\Column(type="boolean" ,options={"default":"1"})
   */
    private $etat;

    public function __construct()
    {
      $this->roles[] = ['ROLE_USER'];
      $this->etat = 1;
    }


  public function getId(): ?int
    {
        return $this->id;
    }


  /**
   * Returns the roles granted to the user.
   *
   *     public function getRoles()
   *     {
   *         return ['ROLE_USER'];
   *     }
   *
   * Alternatively, the roles might be stored on a ``roles`` property,
   * and populated in any number of different ways when the user object
   * is created.
   *
   * @return (Role|string)[] The user roles
   */
  public function getRoles()
  {
    $roles = $this->roles;
    if(empty($roles)){
      $roles[] = 'ROLE_USER';
    }
    return array_unique($roles);
  }

  /**
   * Returns the password used to authenticate the user.
   *
   * This should be the encoded password. On authentication, a plain-text
   * password will be salted, encoded, and then compared to this value.
   *
   * @return string The password
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Returns the salt that was originally used to encode the password.
   *
   * This can return null if the password was not encoded using a salt.
   *
   * @return string|null The salt
   */
  public function getSalt()
  {
    return null;
  }

  /**
   * Returns the username used to authenticate the user.
   *
   * @return string The username
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * Removes sensitive data from the user.
   *
   * This is important if, at any given point, sensitive information like
   * the plain-text password is stored on this object.
   */
  public function eraseCredentials()
  {
    // TODO: Implement eraseCredentials() method.
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

  public function getPrenom(): ?string
  {
      return $this->prenom;
  }

  public function setPrenom(string $prenom): self
  {
      $this->prenom = $prenom;

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

  public function setUsername(string $username): self
  {
      $this->username = $username;

      return $this;
  }

  public function setPassword(string $password): self
  {
      $this->password = $password;

      return $this;
  }

  public function setRoles(array $roles): self
  {
    if(empty($roles)){
      $this->roles = 'ROLE_USER';
    }
    $this->roles = $roles;
    return $this;
  }


  /**
   * String representation of object
   * @link https://php.net/manual/en/serializable.serialize.php
   * @return string the string representation of the object or null
   * @since 5.1.0
   */
  public function serialize()
  {
    return serialize([
      $this->id,
      $this->nom,
      $this->prenom,
      $this->email,
      $this->username,
      $this->password
    ]);
  }

  /**
   * Constructs the object
   * @link https://php.net/manual/en/serializable.unserialize.php
   * @param string $serialized <p>
   * The string representation of the object.
   * </p>
   * @return void
   * @since 5.1.0
   */
  public function unserialize($serialized)
  {
    [
      $this->id,
      $this->nom,
      $this->prenom,
      $this->email,
      $this->username,
      $this->password
    ] = unserialize($serialized,['allowed_classes' => false]);
  }

  public function getEtat(): ?bool
  {
      return $this->etat;
  }

  public function setEtat(bool $etat): self
  {
      $this->etat = $etat;

      return $this;
  }
}
