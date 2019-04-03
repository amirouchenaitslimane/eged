<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
  /**
   * @var ClientRepository
   */
  private $clientRepository;
  /**
   * @var ObjectManager
   */
  private $manager;

  public function __construct(ClientRepository $clientRepository, ObjectManager $manager)
  {
    $this->clientRepository = $clientRepository;
    $this->manager = $manager;
  }

  public function index()
  {
    $clients = $this->clientRepository->findBy([],['nom'=>'ASC']);
      return $this->render('client/index.html.twig', [
         'clients'=>$clients
      ]);
    }

  public function new(Request $request)
  {
    $client = new Client();
    $form = $this->createForm(ClientType::class ,$client);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
      $this->manager->persist($client);
      $this->manager->flush();
      $this->addFlash('success','Le client a été crée avec succès !');
      return $this->redirectToRoute('client');
    }
    return $this->render('client/new.html.twig',[
      'form'=>$form->createView()
    ]);
  }

  public function edit(Request $request,$id)
  {
    $client = $this->clientRepository->find($id);
    $form = $this->createForm(ClientType::class ,$client);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
      $this->manager->persist($client);
      $this->manager->flush();
      $this->addFlash('success','Le client a été actualisé avec succès !');
      return $this->redirectToRoute('client');
    }
    return $this->render('client/edit.html.twig',[
      'form'=>$form->createView(),
      'client'=>$client
    ]);
  }

  public function delete(Request $request,$id)
  {
    $client = $this->clientRepository->find($id);
    $this->manager->remove($client);
    $this->manager->flush();
    $this->addFlash('success','Le client a été eliminé avec succès !');
    return $this->redirectToRoute('client');
  }
}
