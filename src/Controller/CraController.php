<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 10:46
 */

namespace App\Controller;


use App\Entity\Cra;
use App\Form\CraType;
use App\Repository\ClientRepository;
use App\Repository\CraRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CraController extends AbstractController
{
  /**
   * @var CraRepository
   */
  private $repository;
  /**
   * @var ClientRepository
   */
  private $clientRepository;
  /**
   * @var ObjectManager
   */
  private $manager;

  public function __construct(CraRepository $repository,ClientRepository $clientRepository,ObjectManager $manager)
  {
    $this->repository = $repository;
    $this->clientRepository = $clientRepository;
    $this->manager = $manager;
  }

  /**
   * @param Request $request
   * @return Response
   * @throws \Doctrine\DBAL\DBALException
   */
  public function index(Request $request): Response
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
    $clients = $this->clientRepository->findByDate($start,$end);



    $cra = new Cra();
    $form = $this->createForm(CraType::class,$cra);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
      $this->manager->persist($cra);
      $this->manager->flush();
      $this->addFlash('success','Le cra a été ajouté avec succès !');

    }

    return $this->render('cra/index.html.twig',['clients'=>$clients,'start'=>$start,'form'=>$form->createView()]);
  }

  public function add(Request $request)
  {
    if($request->isXmlHttpRequest()) {
      $cra = new Cra();
      $client = $request->get("client");
      $d = $request->get("date");
      $journee = $request->get("journee");
      $c = $this->clientRepository->find($client);
      $cra->setDate(new \DateTime($d));
      $cra->setJournee($journee);
      $cra->setClient($c);
      $this->manager->persist($cra);
      $this->manager->flush();
      $this->addFlash('success','Le cra a été ajouté avec succès !');
      return $this->json(['message'=>'ok']);
    }

  }
  public function remove(Request $request)
  {
    if($request->isXmlHttpRequest()) {
      $id = $request->get("id");
      $cra = $this->repository->find($id);
      $this->manager->remove($cra);
      $this->manager->flush();
      $this->addFlash('success','Le cra a été eliminé avec succès !');
      return $this->json(['message'=>'oki!']);
    }
  }

  public function update(Request $request)
  {
    if($request->isXmlHttpRequest()) {
      $id = $request->get("id");
      $d = $request->get("date");
      $journee = $request->get("journee");
      $cra = $this->repository->find($id);
      $cra->setJournee($journee);
      $cra->setDate(new \DateTime($d));
      $this->manager->persist($cra);
      $this->manager->flush();
      $this->addFlash('success','Le cra a été actualisé avec succès !');
      return $this->json(['message'=>'ok']);
    }

  }

  public function addClient(Request $request){
    if($request->isXmlHttpRequest()) {
      $cra = new Cra();
      $date = $request->get('date');
      $id_client = (int) $request->get('client');
      $client = $this->clientRepository->find($id_client);
      $journee = $request->get('journee');

      $cra->setDate(new \DateTime($date));
      $cra->setClient($client);
      $cra->setJournee($journee);
      $this->manager->persist($cra);
      $this->manager->flush();
      $this->addFlash('success','Le client a été ajouté au cra avec succès !');
      return $this->json(['message'=>'client ajouté ']);
    }

  }
}