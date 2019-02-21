<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 21/02/2019
 * Time: 12:17
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HolidayController extends AbstractController
{
  public function index() :Response
  {
    return $this->render('holiday/index.html.twig');
}
}