<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 03/04/2019
 * Time: 13:11
 */

namespace App\Beta;


use Symfony\Component\HttpFoundation\Response;

class BetaHTMLAdder
{
  public function addBeta(Response $response,$remainingDays)
  {
    $content = $response->getContent();

    // Code à rajouter
    // (Je mets ici du CSS en ligne, mais il faudrait utiliser un fichier CSS bien sûr !)
    $html = '<div class="jumbotron" style="position: absolute; top: 0px; background: orange; width: 100%; text-align: center; padding: 0.5em;">Beta J- '.$remainingDays.'</div>';

    // Insertion du code dans la page, au début du <body>
    $co = str_replace('<body>','<body>'.$html, $content);

    // Modification du contenu dans la réponse
    $response->setContent($co);
    return $response;
  }


}