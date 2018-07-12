<?php
/**
 * Created by PhpStorm.
 * User: helorion
 * Date: 03/07/18
 * Time: 18:13
 */

namespace App\Controller;


use App\AppEvent;
use App\Entity\User;
use App\Event\UserEvent;
use App\Form\UserEditType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProfilController extends Controller
{

    /**
     * @Route(path="/user/show", name="profil_show")
     *
     */
    public function showProfil(){

        /*Recupereation d'un id et permet de prendre que l'user avec l'id*/
        // $participant = $this->getDoctrine()->getManager()->getRepository(User::class)->find($this->getUser()->getId());


        $user=$this->getUser();


        return $this->render('Profil/show.html.twig', ["user"=>$user]);
    }

    /**
     * @Route(path="/user/show/edit", name="profil_edit")
     */
    public function EditProfil(Request $request){

        $user=$this->getUser();

        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $event = $this->get(UserEvent::class);
            $event->setUser($user);
            $dispatcher = $this->get("event_dispatcher");
            $dispatcher->dispatch(AppEvent::USER_EDIT, $event);

            return $this->redirectToRoute("profil_show");
        }

        return $this->render("Profil/edit.html.twig", ["form" => $form->createView()]);


    }

}