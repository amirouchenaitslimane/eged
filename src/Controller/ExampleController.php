<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 20/02/2019
 * Time: 22:10
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExampleController extends AbstractController
{

  public function index()
  {
    return $this->render('example/index.html.twig');
  }
}