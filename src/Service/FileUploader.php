<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 26/02/2019
 * Time: 8:00
 */

namespace App\Service;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
  private $directory;
  /**
   * @var Filesystem $fileSysteme
   */
  private $fileSysteme;
  private $dir;
  private $path;

  public function __construct($directory)
  {
    $this->directory = $directory;
    $this->fileSysteme = new Filesystem();
  }

  public function upload(UploadedFile $file)
  {
    try{
      $fileName =  md5(uniqid()).'.'.$file->guessExtension();
      $file->move($this->createCibleDirectory(),$fileName);
    }catch (UploadException $exception){
      //ici les exception
    }
    return $this->path.'/'.$fileName;
  }

  /**
   * Dans cette methode il manque l'integration des exception
   * @return string
   *
   */
  private function createCibleDirectory()
  {
      $date = new \DateTime('now');
      $dir="";
    if(!$this->fileSysteme->exists($this->directory.'/NDF')){
      $this->fileSysteme->mkdir($this->directory.'/NDF');
    }
    $dir .= $this->directory.'/NDF';
    if(!$this->fileSysteme->exists($dir.'/'.$date->format('Y'))){
      $this->fileSysteme->mkdir($dir.'/'.$date->format('Y'));
    }else{
      $this->dir = $dir.'/'.$date->format('Y');
    }
    if(!$this->fileSysteme->exists($dir.'/'.$date->format('Y').'/'.$date->format('m')))
    {
      $this->fileSysteme->mkdir($dir.'/'.$date->format('Y').'/'.$date->format('m') );
      $this->dir = $dir.'/'.$date->format('Y').'/'.$date->format('m');
    }else{
      $this->dir = $dir.'/'.$date->format('Y').'/'.$date->format('m');

    }

    $this->path =  $date->format('Y').'/'.$date->format('m');


    return $this->path;


  }
}