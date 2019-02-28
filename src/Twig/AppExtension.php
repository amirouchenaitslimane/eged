<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 27/02/2019
 * Time: 20:41
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
  public function getFilters()
  {
    return [
      new TwigFunction('dossier', [$this, 'getDirectory']),
    ];
  }

  public function getDirectory($date)
  {
    $date = explode('/',$date);
    $dir = $date[1].'/'.$date[2].'/';
    return $dir;

  }
}