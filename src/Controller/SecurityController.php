<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * Classe repondant a la securite (Controller de securite / acces)
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{

    /**
     * Fonction permettant de connecter l'utilisateur
     *
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils [ Il permet d'avoir acces a certaines choses en rapport avec l'authentification ]
     * @return \Symfony\Component\HttpFoundation\Response
     */
       public function login(AuthenticationUtils $authenticationUtils)
       {
            # Recuperer les erreurs d'authentification ( AuthenticationUtils )
            $error = $authenticationUtils->getLastAuthenticationError();

            # Recuperer le dernier nom d'utilisateur qui a ete saisi par l'utilisateur
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error
            ]);
       }
}