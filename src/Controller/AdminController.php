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
use App\Form\UserEditType;
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
        $user = $em->getRepository(User::class)->findOrder();

        $pays= $em->getRepository(User::class)->findCountry();

        return $this->render('Admin\listing.html.twig', ['pays'=>$pays, 'user'=>$user]);
    }


    /**
     * @Route(path="admin/edit/{id}", name="admin_edit")
     *
     */
    public function UserEdit(Request $request, User $user)
    {

        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $event = $this->get(UserEvent::class);
            $event->setUser($user);
            $dispatcher = $this->get("event_dispatcher");
            $dispatcher->dispatch(AppEvent::USER_EDIT, $event);

            return $this->redirectToRoute("admin_listing");
        }

        return $this->render("Admin/edit.html.twig", ["form" => $form->createView()]);
    }


    /**
     * @Route(path="admin/delete/{id}", name="admin_delete")
     *
     */
    public function UserDelete(User $user)
    {

        $event = $this->get(UserEvent::class);
        $event->setUser($user);
        $dispatcher = $this->get("event_dispatcher");
        $dispatcher->dispatch(AppEvent::USER_DELETE, $event);

        return $this->redirectToRoute("admin_listing");
    }
}