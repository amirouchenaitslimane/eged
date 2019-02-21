<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 11:20
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FacturationController extends AbstractController
{
  public function index():Response
  {
    return $this->render('facturation/index.html.twig');
  }
}