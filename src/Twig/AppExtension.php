<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 27/02/2019
 * Time: 20:41
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;


class AppExtension extends AbstractExtension
{

  public function getFilters()
  {
    return[
      new TwigFilter('badge',
        [$this,'badgeFilter'],
        ['is_safe'=>['html']]
      )
      
    ];
  }

  public function getFunctions()
  {
    return [
      new TwigFunction('formatType',[$this,'formateType'], ['is_safe'=>['html']]),
      new TwigFunction('totalTtc',[$this,'TotalTtc'], ['is_safe'=>['html']]),
      new TwigFunction('totalHt',[$this,'TotalHt'], ['is_safe'=>['html']]),
      new TwigFunction('totalTaxe',[$this,'totalTaxe'], ['is_safe'=>['html']])
    ];
  }
  
  
  public function badgeFilter($etat)
  {
    $t = "";
    if($etat == 'Brouillon'){
      $t .= "badge-danger";
    }elseif ($etat == 'Envoyee'){
      $t .= "badge-success";
    }

    return "<span class='badge ".$t." p-2'>".$etat."</span>";
  }


  public function formateType($type)
  {
    $string = str_replace('_',' ',$type);
    return ucfirst($string);
  }

  public function totalTtc($objet)
  {
    $ttc = 0;
    foreach ($objet as $frai) {
      $ttc += $frai->getMontantTtc();
    }
    return $ttc.' €';
  }
  public function totalHt($objet)
  {
    $ht = 0;
    foreach ($objet as $frai) {
      $ht += $frai->getMontantHt();
    }
    return $ht.' €';
  }

  public function totalTaxe($frais)
  {
    $taxe = 0;
    foreach ($frais as $frai) {
      $taxe += $frai->getTaxe();
    }
    return $taxe;
  }
}