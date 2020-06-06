<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Personne;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class CryptPasswordSubscriber implements EventSubscriberInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function onKernelView(ViewEvent $event)
    {
        // ...
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($entity instanceof Personne && in_array($method, [Request::METHOD_POST, Request::METHOD_PUT])) {
            $entity->setPassword($this->passwordEncoder->encodePassword(
                $entity,
                $entity->getPassword()
            ));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.view' => ['onKernelView', EventPriorities::PRE_WRITE]
        ];
    }
}
