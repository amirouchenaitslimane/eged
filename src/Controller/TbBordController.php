<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 11:25
 */

namespace App\Controller;


use App\EventListener\BetaListener;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class TbBordController extends AbstractController
{
  public function index()
  {



    return $this->render('tbBord/index.html.twig');
  }
}