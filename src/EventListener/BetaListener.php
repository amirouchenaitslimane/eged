<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 03/04/2019
 * Time: 13:22
 */

namespace App\EventListener;


use App\Beta\BetaHTMLAdder;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
  /**
   * @var BetaHTMLAdder
   */
  protected $betaHTML;
  protected $endDate;

  /**
   * BetaListener constructor.
   * @param BetaHTMLAdder $betaHTML
   * @param $endDate
   * @throws \Exception
   */
  public function __construct(BetaHTMLAdder $betaHTML, $endDate)
  {

    $this->betaHTML = $betaHTML;
    $this->endDate =new \Datetime($endDate);
  }

  /**
   * @throws \Exception
   */
  public function processBeta(FilterResponseEvent $event)
  {
    if (!$event->isMasterRequest()) {
      return;
    }

    $remainingDays = $this->endDate->diff(new \Datetime())->days;

    // Si la date est dépassée, on ne fait rien
    if ($remainingDays <= 0) {
      return;
    }

    // On utilise notre BetaHRML
    $response = $this->betaHTML->addBeta($event->getResponse(), $remainingDays);

    // On met à jour la réponse avec la nouvelle valeur
    $event->setResponse($response);
  }

}