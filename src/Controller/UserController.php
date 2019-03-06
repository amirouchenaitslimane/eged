<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 12:07
 */

namespace App\Controller;


use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
  public function index(Request $request):Response
  {
    $utilisateurs = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->getUsers();

    return $this->render('user/index.html.twig',[
      'users'=>$utilisateurs
    ]);
  }

  public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder)
  {
    $user = new Utilisateur();
    $form = $this->createForm(UtilisateurType::class,$user);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
      $em = $this->getDoctrine()->getManager();
      $user->setPassword($passwordEncoder->encodePassword($user,$user->getPassword()));
      $roles = $form->get('roles')->getData();
      $user->setRoles($roles);
      $em->persist($user);
      $em->flush();
      $this->addFlash('success','L\'utilisateur a été créé avec succès !');
      return $this->redirectToRoute('user');
    }
    return $this->render('user/new.html.twig',[
    'form_user'=>$form->createView(),
    ]);
  }
}