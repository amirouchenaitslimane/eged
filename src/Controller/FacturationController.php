<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 11:20
 */

namespace App\Controller;


use App\Entity\Client;
use App\Entity\Facture;
use App\Form\ClientType;
use App\Form\FactureType;

use App\Repository\FactureRepository;
use App\Repository\SocieteRepository;
use App\Service\FactureToPdf;
use Doctrine\Common\Persistence\ObjectManager;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

  /**
   * FacturationController constructor.
   * @param FactureRepository $factureRepository
   * @param SocieteRepository $societeRepository
   * @param ObjectManager $manager
   */
  public function __construct(FactureRepository $factureRepository,SocieteRepository $societeRepository, ObjectManager $manager)
  {
    $this->manager = $manager;
    $this->factureRepository = $factureRepository;
    $this->societeRepository = $societeRepository;
  }

  /**
   * @return Response
   */
  public function index(Request $request):Response
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
    $factures = $this->factureRepository->findByDate($start,$end);
    return $this->render('facturation/index.html.twig',
      [
        'factures'=>$factures,
        'start'=>$start
      ]
    );
  }

  /**
   * @param Request $request
   * @return Response
   */
  public function new(Request $request)
  {
    $facture = new Facture();
    $client = new Client();
    $form = $this->createForm(ClientType::class,$client);
    $form_facture = $this->createForm(FactureType::class,$facture);
    $form_facture->handleRequest($request);
    if($form_facture->isSubmitted())
    {
      $this->manager->persist($facture);$this->manager->flush();
      $this->addFlash('success','La facture a été crée avec succès !');
      return $this->redirectToRoute('facturation');
    }
    return $this->render('facturation/new.html.twig',
      [
        'form_facture'=>$form_facture->createView(),
        'facture'=>$facture,
        'form'=>$form->createView()
      ]
    );
  }

  /**
   * @param Request $request
   * @param $id
   * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
   */
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

  /**
   * @param Request $request
   * @param $id
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   */
  public function delete(Request $request ,$id)
  {
    $facture = $this->factureRepository->find($id);
    $this->manager->remove($facture);$this->manager->flush();
    $this->addFlash('success','La facture a été eliminée avec succès !');
    return $this->redirectToRoute('facturation');
  }

  /**
   * @param Request $request
   * @param FactureToPdf $pdf //le service des PDFs
   * @param $id
   * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
   */
  public function generate(Request $request,FactureToPdf $pdf, $id)
  {
    $facture = $this->factureRepository->find($id);
    $societe = $this->societeRepository->find(1);
    $html =  $this->renderView('facturation/pdf/facture.html.twig',[
      'facture'=>$facture,
      'societe'=>$societe
    ]);
      $pdf->generatePDF($html,$facture->getClient()->getNom());
  }

  /**
   * Ajout de client avec AJAX
   * @param Request $request
   * @return JsonResponse
   */
  public function addClient(Request $request)
  {
    if (!$request->isXmlHttpRequest()) {
      return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
    }
    if($request->isXmlHttpRequest()){
      $entity = new Client();
      $datas = $request->get("client");
      $entity->setNom($datas['nom']);
      $entity->setAddresse($datas['addresse']);
      $entity->setEmail($datas['email']);
      $entity->setTelephone($datas['telephone']);
      $this->manager->persist($entity);
      $this->manager->flush();
      return new JsonResponse(
        [
        'success'=>'saved',
        'client'=>$datas
        ]
      );
}








    $response = new JsonResponse(array('error'=>'not saved'));

    return $response;
  }




}