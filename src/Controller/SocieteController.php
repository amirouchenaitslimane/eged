<?php

namespace App\Controller;

use App\Entity\Societe;
use App\Form\SocieteType;
use App\Repository\SocieteRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SocieteController extends AbstractController
{
  /**
   * @var SocieteRepository
   */
  private $repository;
  /**
   * @var ObjectManager
   */
  private $manager;

  public function __construct(SocieteRepository $repository, ObjectManager $manager){

    $this->repository = $repository;
    $this->manager = $manager;
  }
    public function index()
    {


      $societe = $this->repository->find(1);
//      dump($societe);die();

        return $this->render('socite/index.html.twig', [
          'societe'=>$societe
        ]);
    }



  public function edit(Request $request,$id)
  {
    $societe = $this->repository->find($id);
    $form = $this->createForm(SocieteType::class,$societe);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
      $this->manager->persist($societe);
      $this->manager->flush();
      $this->addFlash('success','Les donnée de la société ont  été actualisée avec succès !');
      return $this->redirectToRoute('societe');

    }
    return $this->render('socite/edit.html.twig', [
      'societe'=>$societe,
      'form'=> $form->createView(),
    ]);
  }
}
