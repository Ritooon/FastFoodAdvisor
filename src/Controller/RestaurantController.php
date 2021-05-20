<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Form\NotesType;
use App\Entity\Restaurants;
use App\Entity\SearchRestaurant;
use App\Form\SearchRestaurantType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RestaurantsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurants", name="restaurants")
     */
    public function restaurantsList(RestaurantsRepository $repo, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $restaurantFilter = new SearchRestaurant();

        $form = $this->createForm(SearchRestaurantType::class, $restaurantFilter);
        $form->handleRequest($request);

        return $this->render('restaurant/list.html.twig', [
            'restaurants' => $paginatorInterface->paginate(
                $repo->findAllNotDeletedWithPagination($restaurantFilter), 
                $request->query->getInt('page', 1),
                10
            ),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/restaurant/{id}", name="restaurant")
     */
    public function restaurantsDetails(Request $request, EntityManagerInterface $emi, Restaurants $restaurant, Notes $note = null): Response
    {
        if(!$note) { $note = new Notes(); }

        $rateForm = $this->createform(NotesType::class);
        $rateForm->handleRequest($request);

        if($rateForm->isSubmitted() && $rateForm->isValid())
        {
            $note = $rateForm->getData();
            $note->setRestaurant($restaurant);
            $note->setUser($this->getUser());
            $emi->persist($note);
            $emi->flush();   
            $this->addFlash('success', "Merci pour ta note ! Elle a bien été prise en compte");
            return $this->redirectToRoute('restaurant/'.$restaurant->getId());
        }

        return $this->render('restaurant/restaurant_detail.html.twig', [
            'restaurant' => $restaurant,
            'rateForm' => $rateForm->createView()
        ]);
    }
}
