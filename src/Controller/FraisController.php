<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 10:52
 */

namespace App\Controller;


use App\Entity\Frais;
use App\Form\FraisDupliqueType;
use App\Form\FraisType;
use App\Repository\FraisRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FraisController extends AbstractController
{

  /**
   * @var FraisRepository
   */
  private $fraisRepository;
  /**
   * @var ObjectManager
   */
  private $manager;

  public function __construct(FraisRepository $fraisRepository ,ObjectManager $manager)
  {
    $this->fraisRepository = $fraisRepository;
    $this->manager = $manager;
  }

  /**
   * retourner la liste de toutes les note de frais
   * @param Request $request
   * @return Response
   * @throws \Exception
   */
  public function index(Request $request) :Response
  {

    if($request->request->get('date')){
      $date = new \DateTime("01-".$request->request->get('date'));
      $start = $date->format('Y-m-d');
      $end = $date->format('Y-m-t');//dernier jour du mois choisi
    }else{
      $date = new \DateTime('now');//le mois courent
      $start = $date->format('Y-m-01');
      $end = $date->format('Y-m-t');
    }
    //listes des notes de frais dans la base de donnee
    $frais_all = $this->fraisRepository->findByDate($start,$end);

    return $this->render('frais/index.html.twig',
      [
        'frais'=>$frais_all,
        'start'=>$start//le mois ou l'annee choisi | la date curent m-Y
      ]
    );
  }

  /**
   * Ajouter une note de frais
   * @param Request $request
   * @return Response
   */
  public function new(Request $request,ValidatorInterface $validator) :Response
  {

    $frais = new Frais();
    $form = $this->createForm(FraisType::class,$frais);
    $form->handleRequest($request);

    if ($form->isSubmitted()) {
      $error = $validator->validate($frais);
      if($form->isValid()){
        $this->manager->persist($frais);
        $this->manager->flush();
        $this->addFlash('success','La not de frais a été crée avec succès !');
      }else{
        $this->addFlash('danger','La not de frais non enregistre !');
      }

    }else{
      $error = null;
    }
    return $this->render('frais/new.html.twig',
      [
        'form'=>$form->createView(),
        'errors'=>$error,
      ]);
  }

  /**
   * Edition de la note de frai
   * @param Request $request
   * @param $id int identifiant de la note de frais
   * @return Response
   */

  public function edit(Request $request,$id,ValidatorInterface $validator)
  {
    $frais = $this->fraisRepository->find($id);

    if(!$frais){
      throw $this->createNotFoundException('frais demander n\'existe pas ');
    }
    //$error = null;
    $form = $this->createForm(FraisType::class,$frais);
    $form->handleRequest($request);

    if ($form->isSubmitted() ) {
      $error = $validator->validate($frais);
      if($form->isValid()){
        $this->manager->persist($frais);
        $this->manager->flush();
        $this->addFlash('success','La note de frais a été actualisée avec succés !');
      }else{
        $this->addFlash('danger','La note de frais na pas été actualisée  !');
      }

    }else{
      $error = null;
    }
    return $this->render('frais/edit.html.twig',[
      'form'=>$form->createView(),
      'errors'=>$error,
      'frais'=>$frais,
    ]);
  }

  /**
   * elimination de la note frais
   * @param Request $request
   * @param $id int identifiant de la note de frais
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   */

  public function delete(Request $request,$id)
  {
    $frais = $this->fraisRepository->find($id);
    if(!$frais){
      throw $this->createNotFoundException('frais demander n\'existe pas ');
    }
    $this->manager->remove($frais);
    $this->manager->flush();
    $this->addFlash('success','La note de frais a été eliminée avec succès !');
    return $this->redirectToRoute('frais');
  }

  /**
   * duplication de la note de frais
   * @param Request $request
   * @param $id
   * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
   */
  public function dupliquer(Request $request ,$id)
  {

    $frais = $this->fraisRepository->find($id);
    $frais_new = clone $frais;//ont cree un nouvel objet avant la submission de formulaire
    $form = $this->createForm(FraisDupliqueType::class,$frais_new);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
      $this->manager->persist($frais_new);
      $this->manager->flush();
      $this->addFlash('success','La note de frais a été dupliquée avec succès !');
      return $this->redirectToRoute('frais');
    }
    return $this->render('frais/duplique.html.twig',[
     'form'=>$form->createView(),
      'frais'=>$frais,
    ]);
  }


}