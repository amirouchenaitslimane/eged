<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 12:15
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TvaController extends AbstractController
{
  public function index()
  {
      return $this->render('tva/index.html.twig');
  }
}