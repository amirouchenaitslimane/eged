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
      $end = $date->format('Y-m-t');


    }else{
      $date = new \DateTime('now');
      $start = $date->format('Y-m-01');
      $end = $date->format('Y-m-t');

    }

    $frais_all = $this->em()->getRepository(Frais::class)->findByDate($start,$end);

    return $this->render('frais/frais.html.twig',
      [
        'frais'=>$frais_all,
        'start'=>$start
      ]
    );
  }

  public function new(Request $request) :Response
  {
    $em = $this->getDoctrine()->getManager();
    $frais = new Frais();
    $form = $this->createForm(FraisType::class,$frais);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($frais);
      $em->flush();
      $this->addFlash('success','success !');
    }
    return $this->render('frais/new.html.twig',
      [
        'form'=>$form->createView(),
      ]);
  }

  private function montantTTc(){
    //Formule : [Montant HT] x (1 + ([Taux TVA] / 100))=[Montant TTC]
  }

  private function montantHt(){
    //Formule : [Montant TTC] / (1 + ([Taux TVA] / 100))=[Montant HT]
  }

  private function montantTva(){
   // Formule : [Montant HT] x ([Taux TVA] / 100)=[Montant TVA]
  }


  public function edit(Request $request,$id)
  {
    $frais = $this->em()->getRepository(Frais::class)->find($id);
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
  public function delete(Request $request,$id)
  {

    return $this->render('frais/delete.html.twig');
  }
}