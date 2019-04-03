<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{

  /**
   * @var DocumentRepository
   */
  private $dr;
  /**
   * @var ObjectManager
   */
  private $manager;

  public function __construct(DocumentRepository $dr, ObjectManager $manager)
  {
    $this->dr = $dr;
    $this->manager = $manager;
  }

  public function index(Request $request)
    {
      if($request->request->get('date')){
        $date = new \DateTime("01-01-".$request->request->get('date'));
        $start = $date->format('Y-m-d');
        $end = $date->format('Y-12-t');//dernier jour du mois choisi
      }else{
        $date = new \DateTime('now');//le mois courent
        $start = $date->format('Y-01-01');
        $end = $date->format('Y-12-t');
      }
      $documents = $this->dr->findByDate($start,$end);
        return $this->render('document/index.html.twig', [
          'documents'=>$documents,
          'start'=>$start
        ]);
    }

  public function new(Request $request)
  {
    $document = new Document();
    $form = $this->createForm(DocumentType::class,$document);
    $form->handleRequest($request);
    if($form->isSubmitted()){
      if($form->isValid()){
        $this->manager->persist($document);
        $this->manager->flush();
        $this->addFlash('success','Le documment a été ajouté avec succès !');

      }else{
        $this->addFlash('danger','Le documment n\'a pas été ajouté !');

      }
      return $this->redirectToRoute('document');
    }
    return $this->render('document/new.html.twig',[
      'form'=>$form->createView()
    ]);
  }

  public function edit(Request $request,$id)
  {
    $document = $this->dr->find($id);
    if(!$document){
      throw $this->createNotFoundException('Documment demandé n\'existe pas ');
    }
    $form = $this->createForm(DocumentType::class,$document);
    $form->handleRequest($request);
    if($form->isSubmitted()){
      if($form->isValid()){
        $this->manager->persist($document);
        $this->manager->flush();
        $this->addFlash('success','Le documment a été actualisé avec succès !');
      }else{
        $this->addFlash('danger','Le documment na pas été actualisé  !');
      }
      return $this->redirectToRoute('document');
    }
    return $this->render('document/edit.html.twig',[
      'form'=>$form->createView(),
      'document'=>$document
    ]);
  }

  public function delete(Request $request,$id)
  {
    $document = $this->dr->find($id);
    if(!$document){
      throw $this->createNotFoundException('Documment demandé n\'existe pas ');
    }
    $this->manager->remove($document);
    $this->manager->flush();
    $this->addFlash('success','Le documment a été eliminé avec succès !');
    return $this->redirectToRoute('document');
  }
}
