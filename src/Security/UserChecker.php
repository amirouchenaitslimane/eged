<?php
/**
 * Created by PhpStorm.
 * User: Ami
 * Date: 07/03/2019
 * Time: 7:54
 */

namespace App\Security;


use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

  /**
   * Checks the user account before authentication.
   *
   * @throws AccountStatusException
   */
  public function checkPreAuth(UserInterface $user)
  {
    if(!$user instanceof Utilisateur){
      return;
    }

    if($user->getEtat()=== false){
      throw new CustomUserMessageAuthenticationException(
        'Votre compte a ete desactivé!'
      );
    }
  }

  /**
   * Checks the user account after authentication.
   *
   * @throws AccountStatusException
   */
  public function checkPostAuth(UserInterface $user)
  {
    // TODO: Implement checkPostAuth() method.
  }
}