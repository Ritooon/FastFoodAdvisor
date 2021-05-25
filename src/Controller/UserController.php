<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegisterType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/account_created", name="account_created")
     */
    public function createdAccountMessage(): Response
    {
        return $this->render('user/account_created.html.twig');
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, EntityManagerInterface $emi, UserPasswordEncoderInterface $encoder, MailerInterface $mailer): Response
    {
        $user = new Users();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $randToken = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
            $crypted = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($crypted);
            $user->setRoles('ROLE_USER');
            $emi->persist($user);
            $emi->flush();
            return $this->redirectToRoute('account_created');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()            
        ]);
    }
    
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $utils): Response
    {
        return $this->render('user/login.html.twig', [
            'lastUserName' => $utils->getLastUsername(),
            'error' => $utils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {}
}
