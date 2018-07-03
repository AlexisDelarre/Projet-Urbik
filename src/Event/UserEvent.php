<?php

namespace App\Event;


use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;


/**
 * Created by PhpStorm.
 * User: alexis.delarre
 * Date: 09/02/18
 * Time: 13:30
 */

class UserEvent extends Event

{
    public $user;

    /**
     * UserEvent constructor.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }





}
