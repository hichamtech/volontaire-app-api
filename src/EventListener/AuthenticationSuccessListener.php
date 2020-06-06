<?php

namespace App\EventListener;

use App\Entity\Personne;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
  private $em;

  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }

  /**
   * @param AuthenticationSuccessEvent $event
   */
  public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
  {

    $data = $event->getData();
    $user = $event->getUser();

    if (!$user instanceof Personne) {
      return;
    }

    $user->setLastConnection(new DateTime());
    $this->em->flush();

    $data['data'] = [
      'roles' => $user->getRoles(),
      'email' => $user->getEmail(),
    ];
    $data['id'] = $user->getId();
    $data['role'] = $user->getRoles();
    $data['email'] = $user->getEmail();
    $data['nom'] = $user->getNom();
    $data['password'] = $user->getPassword();
    $data['prenom'] = $user->getPrenom();
    $data['status'] = "success";
    $event->setData($data);
  }
}
