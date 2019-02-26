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
  public function index(Request $request) :Response
  {
    $em = $this->getDoctrine()->getManager();
    $frais = new Frais();
    $form = $this->createForm(FraisType::class,$frais);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

//      $file = $form->get('justificatif')->getData();
//      $fileName = $fileUploader->upload($file);
//      $frais->setJustificatif($fileName);

    }


    return $this->render('frais/frais.html.twig',
      [
        'form'=>$form->createView(),
      ]);
  }
}