<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 15/03/2019
 * Time: 10:22
 */

namespace App\Service;


use Spipu\Html2Pdf\Html2Pdf;

class FactureToPdf
{

  /**
   * @param $view
   * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
   */
  public function generatePDF($view,$name)
  {
    $pdf = new Html2Pdf();
    $pdf->pdf->SetDisplayMode('fullpage');
    $pdf->writeHTML($view);
    $pdf->pdf->SetTitle($name);
    $pdf->output($this->generateNamePdf($name));
  }



  private function generateNamePdf($name){
   $name_slash = str_replace(' ','_',$name);
   return md5(uniqid()).$name_slash.'.pdf';
  }
}