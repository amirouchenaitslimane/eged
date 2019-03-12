<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 11/03/2019
 * Time: 20:59
 */

namespace App\Service;


use App\Entity\Document;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class DocumentNamer implements DirectoryNamerInterface
{

  /**
   * @param Document $document
   * @param PropertyMapping $mapping
   * @return string
   */
  public function directoryName($document, PropertyMapping $mapping): string
  {
    return $document->getDate()->format('Y').'/'.$document->getType();
  }
}