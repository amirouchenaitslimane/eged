<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 11:20
 */

namespace App\Controller;


use App\Entity\Facture;
use App\Form\FactureType;

use App\Repository\FactureRepository;
use App\Repository\SocieteRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FacturationController extends AbstractController
{


  /**
   * @var ObjectManager
   */
  private $manager;
  /**
   * @var FactureRepository
   */
  private $factureRepository;
  /**
   * @var SocieteRepository
   */
  private $societeRepository;

  public function __construct(FactureRepository $factureRepository,SocieteRepository $societeRepository, ObjectManager $manager)
  {

    $this->manager = $manager;
    $this->factureRepository = $factureRepository;
    $this->societeRepository = $societeRepository;
  }
  public function index():Response
  {
    $factures = $this->factureRepository->findAll();
    return $this->render('facturation/index.html.twig',
      [
        'factures'=>$factures,
      ]
    );


  }

  public function new(Request $request)
  {
    $facture = new Facture();
    $form = $this->createForm(FactureType::class,$facture);
    $form->handleRequest($request);
    if($form->isSubmitted())
    {
      $this->manager->persist($facture);$this->manager->flush();
    }
    return $this->render('facturation/new.html.twig',
      [
        'form'=>$form->createView(),
        'facture'=>$facture
      ]
    );

  }

  public function edit(Request $request, $id)
  {
    $facture = $this->factureRepository->find($id);
    if(!$facture){
      throw $this->createNotFoundException('Facture demandé n\'existe pas');
    }
    $form = $this->createForm(FactureType::class,$facture);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
      $this->manager->persist($facture);
      $this->manager->flush();
      $this->addFlash('success','La facture a été actualisée avec succès !');
      return $this->redirectToRoute('facturation');
    }
    return $this->render('facturation/edit.html.twig',[
      'facture'=>$facture,
      'form'=>$form->createView()
    ]);
  }

  public function delete(Request $request ,$id)
  {
    $facture = $this->factureRepository->find($id);
    $this->manager->remove($facture);$this->manager->flush();
    $this->addFlash('success','La facture a été eliminée avec succès !');
    return $this->redirectToRoute('facturation');
  }

  public function generate(Request $request,$id)
  {
    $facture = $this->factureRepository->find($id);
    $societe = $this->societeRepository->find(1);

    return $this->render('facturation/facture.html.twig',[
      'facture'=>$facture,
      'societe'=>$societe
    ]);
  }
}