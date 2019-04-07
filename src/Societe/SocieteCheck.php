<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 03/04/2019
 * Time: 20:30
 */

namespace App\Societe;


use App\Entity\Societe;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Session\Session;


class SocieteCheck
{

  /**
   * @var EntityManager
   */
  private $em;
  /**
   * @var RouterInterface
   */
  private  $router;
  /**
   * @var Session
   */
  private $session;

  public function __construct(EntityManager $em,RouterInterface $router,Session $session) {
    $this->em = $em;
    $this->router = $router;
    $this->session = $session;
  }

  public function onKernelResponse(FilterResponseEvent $event)
  {
      $societe = $this->em->getRepository(Societe::class)->findAll();
     if(empty($societe)){
       $url = $event->getRequest()->getPathInfo();
        if($url === '/facturation' || $url === '/facturation/new' || $url === '/societe'){
            $this->session->getFlashBag()->add('info','Vous devez cree une societe pour pouvoire accedez je sait pas quoi mettre');
          return $event->setResponse(new RedirectResponse($this->router->generate('societe_new')));
        }
     }else{
       return;
     }
  }
}