<?php
/**
 * Created by PhpStorm.
 * User: helorion
 * Date: 04/07/18
 * Time: 14:35
 */

namespace App\Controller;

use App\AppEvent;
use App\Event\UserEvent;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin/listing", name="admin_listing")
     */
    public function userManagement()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findAll();

        return $this->render('Admin\listing.html.twig',['user'=>$user]);
    }


    /**
     * @Route(path="admin/edit/{id}", name="admin_edit")
     *
     */
    public function editConference(Request $request, User $user)
    {

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $event = $this->get(UserEvent::class);
            $event->setUser($user)->getName();
            $dispatcher = $this->get("event_dispatcher");
            $dispatcher->dispatch(AppEvent::USER_EDIT, $event);

            return $this->redirectToRoute("admin_listing");
        }

        return $this->render("Admin/edit.html.twig", ["form" => $form->createView()]);
    }
}