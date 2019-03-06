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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
  /**
   * @Route("/login", name="security_login")
   */
  public function login(AuthenticationUtils $utils): Response
  {
    return $this->render('security/login.html.twig', [
      'last_username' => $utils->getLastUsername(),
      'error' => $utils->getLastAuthenticationError(),
    ]);
  }
  /**
   *
   * @Route("/logout", name="security_logout")
   *
   * @throws \Exception
   */
  public function logout(): void
  {
    throw new \Exception('This should never be reached!');
  }
}