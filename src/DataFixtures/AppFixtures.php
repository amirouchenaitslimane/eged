<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
  private $encoder;//pour coder le mot de pass

  public function __construct(UserPasswordEncoderInterface $encoder)
  {
    $this->encoder = $encoder;
  }

  public function load(ObjectManager $manager)
    {
       $this->loadUtilisateurs($manager);
      $this->loadClient($manager);
    }

  public function loadClient(ObjectManager $manager)
  {
    foreach ($this->listClients() as [$nom,$adress,$email,$telephone]) {
      $client = new Client();
      $client->setNom($nom)->setAddresse($adress)->setEmail($email)->setTelephone($telephone);
    $manager->persist($client);
    }
    $manager->flush();
  }
  public function loadUtilisateurs(ObjectManager $manager)
  {
    foreach ($this->listUtilisateurs() as [$nom,$prenom,$email,$username,$password,$roles]) {
      $utilisateur = new Utilisateur();
      $utilisateur->setNom($nom);
      $utilisateur->setPrenom($prenom);
      $utilisateur->setEmail($email);
      $utilisateur->setUsername($username);
      $utilisateur->setPassword($this->encoder->encodePassword($utilisateur,$password));
      $utilisateur->setRoles($roles);
      $manager->persist($utilisateur);
      $this->addReference($username, $utilisateur);
    }

    $manager->flush();
  }

  public function listUtilisateurs()
  {
      return[
        //$nom,  $prenom,    $email,       $username,$password,    $roles
        ['samir','samir','samir@gmail.com','admin','admin',['ROLE_SUPER_ADMIN']],
        ['utilisateur1','utilisateur1','utilisateur1@gmail.com','user1','user1',['ROLE_USER']],
        ['utilisateur2','utilisateur2','utilisateur2@gmail.com','user2','user2',['ROLE_USER']],
        ['utilisateur3','utilisateur3','utilisateur3@gmail.com','user3','user3',['ROLE_USER']],
        ['utilisateur4','utilisateur4','utilisateur4@gmail.com','user4','user4',['ROLE_USER']],
        ['utilisateur5','utilisateur5','utilisateur5@gmail.com','user5','user5',['ROLE_USER']],
        ['utilisateur6','utilisateur6','utilisateur6@gmail.com','user6','user6',['ROLE_USER']],
        ['utilisateur7','utilisateur7','utilisateur7@gmail.com','user7','user7',['ROLE_USER']],
        ['utilisateur8','utilisateur8','utilisateur8@gmail.com','user8','user8',['ROLE_USER']],
        ['utilisateur1','utilisateur9','utilisateur9@gmail.com','user9','user9',['ROLE_USER']],
        ['utilisateur10','utilisateur10','utilisateur10@gmail.com','user10','user10',['ROLE_USER']],
        ['utilisateur11','utilisateur11','utilisateur11@gmail.com','user11','user11',['ROLE_USER']],
      ];
  }

  private function listClients()
  {
    //nom adress email , telephone

    return [
      ['nom1','adress client 1','email1@gmail.com','675489562'],
      ['nom2','adress client 2','email2@gmail.com','675489563'],
      ['nom3','adress client 3','email3@gmail.com','675489573'],
      ['nom4','adress client 4','email4@gmail.com','675489584'],
      ['nom5','adress client 5','email5@gmail.com','675489105'],
      ['nom6','adress client 6','email6@gmail.com','675489116'],
      ['nom7','adress client 7','email7@gmail.com','675489567'],
      ['nom8','adress client 8','email8@gmail.com','675489568'],
      ['nom9','adress client 9','email9@gmail.com','675489569'],
      ['nom10','adress client 10','email10@gmail.com','675489510'],
      ['nom11','adress client 11','email11@gmail.com','675489511']
    ];

  }
}
