<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 26/02/2019
 * Time: 8:22
 */

namespace App\EventListener;


use App\Entity\Frais;
use App\Service\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class JustificatifUploadListener
{
  private $uploader;
  public function __construct(FileUploader $fileUploader)
  {
    $this->uploader = $fileUploader;
  }

  public function prePersist(LifecycleEventArgs $args)
  {
    $entity = $args->getEntity();
    $this->uploadFile($entity);

  }

  public function preUpdate(PreUpdateEventArgs $args){
    $entity = $args->getEntity();

    $this->uploadFile($entity);
  }

  public function uploadFile($entity)
  {
    if(!$entity instanceof Frais)
    {
      return;
    }
    $file =$entity->getJustificatif();
    if($file instanceof UploadedFile)
    {
      $fileName = $this->uploader->upload($file);
      $entity->setJustificatif($fileName);
    }elseif($file instanceof File){
      $entity->setJustificatif($file);
    }
  }
}