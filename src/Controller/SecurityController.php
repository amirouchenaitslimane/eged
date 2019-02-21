<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 10:29
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
  public function login() :Response
  {
    return $this->render('security/login.html.twig');
  }
}