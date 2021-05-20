<?php

namespace App\Controller;

use App\Entity\SearchRestaurant;
use App\Form\SearchRestaurantType;
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
    public function restaurantsDetails(RestaurantsRepository $repo, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        return $this->render('restaurant/restaurant_detail.html.twig', [
            'restaurants' => $paginatorInterface->paginate(
                $repo->findAllNotDeletedWithPagination(), 
                $request->query->getInt('page', 1),
                10
            )
        ]);
    }
}
