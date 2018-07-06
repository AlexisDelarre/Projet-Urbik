<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authUtils) {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {

    }

    /**
     * @Route("/register", name="register", methods={"GET","HEAD"})
     */
    public function register() {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        return $this->render('security/register.html.twig', ['form' => $form->createView(),]);
    }

    /**
     * @Route("/register", name="check_register", methods="POST")
     */
    public function check_register(Request $request, UserPasswordEncoderInterface $encoder, Swift_Mailer $mailer) {


        $ip= $this->container->get('request_stack')->getCurrentRequest()->getClientIp();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $encodedPassword = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encodedPassword);
            $user->setAddr($ip);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $message = (new \Swift_Message('Confirmation Inscription'))
                ->setFrom('exercice123.123@gmail.com')
                ->setTo($user->getEmail())
                ->setBody("Vous vous êtes inscris avec les informations suivantes :". $this->renderView(

                        'email/emailuser.html.twig', ["users" => $user]));
            $mailer->send($message);

            $message = (new \Swift_Message("Nouveau inscrit"))
                ->setFrom('exercice123.123@gmail.com')
                ->setTo('exercice123.123@gmail.com')
                ->setBody("un nouvel inscrit sur le site, ses informations sont les suivantes :". $this->renderView(

                        'email/emailadmin.html.twig', ["users" => $user]));
            $mailer->send($message);

            return $this->redirectToRoute('homepage');
        }
        return $this->render('security/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}
