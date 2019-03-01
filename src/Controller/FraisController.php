<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 10:52
 */

namespace App\Controller;


use App\Entity\Frais;
use App\Form\FraisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FraisController extends AbstractController
{
  protected $em;//entity manager

  /**
   * @return \Doctrine\Common\Persistence\ObjectManager
   */
  private function em()
  {
    $this->em = $this->getDoctrine()->getManager();
    return $this->em;
  }

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
    $frais_all = $this->em()->getRepository(Frais::class)->findByDate($start,$end);

    return $this->render('frais/frais.html.twig',
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
  public function new(Request $request) :Response
  {
    $em = $this->getDoctrine()->getManager();
    $frais = new Frais();
    $form = $this->createForm(FraisType::class,$frais);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($frais);
      $em->flush();
      $this->addFlash('success','La Note De Frais A Été Crée Avec Succee !');
    }
    return $this->render('frais/new.html.twig',
      [
        'form'=>$form->createView(),
      ]);
  }

  /**
   * Edition de la note de frai
   * @param Request $request
   * @param $id int identifiant de la note de frais
   * @return Response
   */

  public function edit(Request $request,$id)
  {
    $frais = $this->em()->getRepository(Frais::class)->find($id);

    if(!$frais){
      throw $this->createNotFoundException('Frais Demander N\'existe Pas ');
    }
    $form = $this->createForm(FraisType::class,$frais);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $this->em()->persist($frais);
      $this->em()->flush();
      $this->addFlash('success','success !');
    }
    return $this->render('frais/edit.html.twig',[
      'form'=>$form->createView(),
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
    $frais = $this->em()->getRepository(Frais::class)->find($id);
    if(!$frais){
      throw $this->createNotFoundException('Frais Demander N\'existe Pas ');
    }
    $this->em()->remove($frais);
    $this->em()->flush();
    $this->addFlash('danger','frais deleted ! ');
    return $this->redirectToRoute('frais');
  }
}