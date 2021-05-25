<?php

namespace App\Controller;

use App\Entity\ModificationSuggestion;
use App\Entity\Notes;
use App\Form\NotesType;
use App\Entity\Restaurants;
use App\Entity\SearchRestaurant;
use App\Form\ModificationSuggestionType;
use App\Form\SearchRestaurantType;
use App\Repository\ModificationSuggestionRepository;
use App\Repository\NotesRepository;
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
     * @Route("/restaurant/{id}", name="restaurant", methods="GET|POST")
     */
    public function restaurantsDetails(Request $request, EntityManagerInterface $emi, Restaurants $restaurant, Notes $note = null
        , NotesRepository $noteRepo, ModificationSuggestionRepository $modificationRepo, ModificationSuggestion $modification = null): Response
    {
        // Rating 
        if(!$note || !$this->getUser()) { $note = new Notes(); }

        if($this->getUser() && $this->getUser()->getId()) 
        {
            $note = $noteRepo->findOneBy(['user' => $this->getUser()]);
        }

        $rateForm = $this->createform(NotesType::class);
        $rateForm->handleRequest($request);

        if($rateForm->isSubmitted() && $rateForm->isValid())
        {
            if(!$note->getId())
            { 
                $note = $rateForm->getData(); 
            }

            $note->setRestaurant($restaurant);
            $note->setUser($this->getUser());
            $note->setComment($rateForm->getData()->getComment());
            $note->setRating($rateForm->getData()->getRating());
            $emi->persist($note);
            $emi->flush();   
            $this->addFlash('success', "Merci pour ta note ! Elle a bien été prise en compte");
            return $this->redirectToRoute('restaurant', ['id' => $restaurant->getId()]);
        }

        // Modification suggestion 
        if(!$modification || !$this->getUser()) { $modification = new ModificationSuggestion(); }
        
        $modificationForm = $this->createform(ModificationSuggestionType::class);
        $modificationForm->handleRequest($request);

        $pendingModification = NULL;
        if($this->getUser() && $this->getUser()->getId()) 
        {
            $pendingModification = $modificationRepo->findOneBy(['user' => $this->getUser(), 'isFinished' => 0, 'restaurant' => $restaurant]);
        }

        if($modificationForm->isSubmitted() && $modificationForm->isValid())
        {
            if(!$modification->getId())
            { 
                $modification = $modificationForm->getData(); 
            }

            $modification->setUser($this->getUser());
            $modification->setPhone($modificationForm->getData()->getPhone());
            $modification->setEmail($modificationForm->getData()->getEmail());
            $modification->setWebsite($modificationForm->getData()->getWebsite());
            $modification->setRestaurantName($modificationForm->getData()->getRestaurantName());
            $modification->setIsFinished(0);
            $modification->setRestaurant($restaurant);
            $emi->persist($modification);
            $emi->flush();   
            $this->addFlash('success', "Merci pour ta suggestion ! Elle a bien été prise en compte et nous allons l'examiner");
            return $this->redirectToRoute('restaurant', ['id' => $restaurant->getId()]);
        }


        return $this->render('restaurant/restaurant_detail.html.twig', [
            'restaurant' => $restaurant,
            'note' => $note,
            'rateForm' => $rateForm->createView(),
            'pendingModification' => $pendingModification,
            'modificationForm' => $modificationForm->createView()
        ]);
    }    
}
