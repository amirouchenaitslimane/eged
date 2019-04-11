<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 27/02/2019
 * Time: 20:41
 */

namespace App\Twig;


use App\Entity\Facture;
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
      ),
      new TwigFilter('badge_user',
        [$this,'badgeUserFilter'],
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
      new TwigFunction('totalTaxe',[$this,'totalTaxe'], ['is_safe'=>['html']]),
     new TwigFunction('format_etat_user',[$this,'formatEtatUser'], ['is_safe'=>['html']]),
      new TwigFunction('factureTtc',[$this,'factureTotalTtc'], ['is_safe'=>['html']]),
      new TwigFunction('factureHt',[$this,'factureHt'], ['is_safe'=>['html']]),
      new TwigFunction('factureTva',[$this,'factureTva'], ['is_safe'=>['html']]),


//
    ];
  }
  
  
  public function badgeFilter($etat)
  {
    $t = "";
    if($etat == 'brouillon'){
      $t .= "badge-danger";
    }elseif ($etat == 'envoyee'){
      $t .= "badge-success";
    }elseif ($etat == 'validee'){
      $t .= "badge-info";
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

  public function badgeUserFilter($user)
  {
    $t = "";
    if($user->getEtat() == 1){
      $t.="alert-success";
    }elseif($user->getEtat() == 0){
      $t.="alert-danger";
    }

    return "<span class='badge ".$t." p-2'>".$this->formatEtatUser($user)."</span>";

  }

  public function formatEtatUser($user)
  {
    $str = "";
    if($user->getEtat() == 0){
      $str .= "Inactif";
    }else{
      $str .= "Actif";
    }
    return $str;
  }

  /**
   * @param array[] $factures
   */
public function factureTotalTtc($factures){
  $ttc = 0;

  foreach ($factures as $facture) {
    $ttc += $facture->getTotalTtc();
  }
  return $ttc;
}

  public function factureHt($factures)
  {
    $ht = 0;

    foreach ($factures as $facture) {
      $ht += $facture->getTotalHt();
    }
    return $ht;

  }

  public function factureTva($factures)
  {
    $total_tva = 0;

    foreach ($factures as $facture) {
      $total_tva += $facture->getTotalTva();
    }
    return $total_tva;
  }


}