<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 12:07
 */

namespace App\Controller;


use App\Entity\Utilisateur;

use App\Form\Security\EditType;
use App\Form\Security\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
  //Refactoring .....
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
    if($form->isSubmitted()){
      if($form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $user->setPassword($passwordEncoder->encodePassword($user,$user->getPassword()));
        $roles = $form->get('roles')->getData();
        $user->setRoles($roles);
        $em->persist($user);
        $em->flush();
        $this->addFlash('success','L\'utilisateur a été créé avec succès !');

      }else{
        $this->addFlash('danger','L\'utilisateur n\' a pas été créé ');

      }
      return $this->redirectToRoute('user');
    }
    return $this->render('user/new.html.twig',[
    'form_user'=>$form->createView(),
    ]);
  }


  public function edit(Request $request,UserPasswordEncoderInterface $encoder,$id): Response
  {
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository(Utilisateur::class)->find($id);
    if(!$user){
      throw $this->createNotFoundException('Utilisateur demander n\'existe pas ');
    }

    $mot_de_passe_origine = $user->getPassword();
    $form = $this->createForm(EditType::class, $user);
    $form->handleRequest($request);
    if ($form->isSubmitted()) {
      $user = $form->getData();
      $pwd = $user->getPassword() ? $encoder->encodePassword($user, $user->getPassword()) : $mot_de_passe_origine;
       $user->setPassword($pwd);
      if($form->isValid()){
        $em->persist($user);
        $em->flush();
     $this->addFlash('success', 'L\'utilisateur a été actualisé avec succès !');

  }else{
        $this->addFlash('danger', 'L\'utilisateur n\'a pas été actualisé  !');

      }
      return $this->redirectToRoute('user');
    }
    return $this->render('user/edit.html.twig', [
      'user' => $user,
      'form_user' => $form->createView(),
    ]);
  }

  public function delete(Request $request,$id)
  {
    $em = $this->getDoctrine()->getManager();
     $user = $em->getRepository(Utilisateur::class)->find($id);
    if(!$user){
      throw $this->createNotFoundException('Utilisateur demander n\'existe pas ');
    }
    $em->remove($user);
    $em->flush();
    $this->addFlash('success','L\'utilisateur a été eliminée avec succès !');
    return $this->redirectToRoute('user');
  }



}