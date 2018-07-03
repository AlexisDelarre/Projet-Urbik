<?php
/**
 * Created by PhpStorm.
 * User: alexis.delarre
 * Date: 09/02/18
 * Time: 13:51
 */


namespace App\EventListerner;

use App\AppEvent;
use App\Event\UserEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
class UserSubscriber implements EventSubscriberInterface
{
    private $em;

    /**
     * UserSubscriber constructor.
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            AppEvent::USER_DELETE =>array("remove",0),
            AppEvent::USER_EDIT => array ("edit",0)

        ];
    }



    public function edit(UserEvent $userEvent)
    {
        $this->em->persist($userEvent->getUser());
        $this->em->flush();
    }

    public function remove(UserEvent $userEvent)
    {
        $this->em->remove($userEvent->getUser());
        $this->em->flush();
    }


}