<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 28/02/2019
 * Time: 14:21
 */

namespace App\Service;


use Doctrine\ORM\EntityManager;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class DirectoryNamer implements DirectoryNamerInterface
{


  /**
   * Creates a directory name for the file being uploaded.
   *
   * @param object $object The object the upload is attached to
   * @param PropertyMapping $mapping The mapping to use to manipulate the given object
   *
   * @return string The directory name
   */
  public function directoryName($frais, PropertyMapping $mapping): string
  {
    return $frais->getDate()->format('Y').'/'.$frais->getDate()->format('m');

  }
}