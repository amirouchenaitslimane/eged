<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 11:25
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TbBordController extends AbstractController
{
  public function index():Response
  {
    return $this->render('tbBord/index.html.twig');
  }
}