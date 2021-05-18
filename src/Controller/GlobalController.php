<?php

namespace App\Controller;

use App\Entity\Cities;
use App\Entity\Users;
use App\Form\RegisterType;
use App\Repository\RestaurantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GlobalController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(RestaurantsRepository $restaurantsRepo): Response
    {
        $bestRestaurants = $restaurantsRepo->getTopFive();

        return $this->render('global/index.html.twig', [
            'controller_name' => 'GlobalController',
            'topFiveRestaurants' => $bestRestaurants
        ]);
    }

    /**
     * @Route("/toogle_theme/{theme}", name="toogle_theme")
     */
    public function toogleTheme($theme)
    {
        if($theme == 'dark-theme' || $theme == 'light-theme') {
            setcookie("theme", $theme, mktime(). time()+60*60*24*30);
        }
        
        return $this->render('global/blank.html.twig');
    }
}
