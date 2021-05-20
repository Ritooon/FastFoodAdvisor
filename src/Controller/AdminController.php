<?php

namespace App\Controller;

use ArrayObject;
use App\Entity\Cities;
use App\Entity\Restaurants;
use App\Form\RestaurantType;
use App\Repository\CitiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RestaurantsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/restaurants", name="restaurants_admin")
     */
    public function index(RestaurantsRepository $repo, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        return $this->render('admin/restaurants.html.twig', [
            'restaurants' => $paginatorInterface->paginate(
                $repo->findAllNotDeletedWithPagination(), 
                $request->query->getInt('page', 1),
                10
            )
        ]);
    }

    /**
     * @Route("/admin/restaurant-deletion/{id}", name="del-restaurant", methods="DEL")
     */
    public function delRestaurant(Restaurants $restaurant, Request $request, EntityManagerInterface $emi): Response
    {
        if($this->isCsrfTokenValid('DEL'.$restaurant->getId(), $request->get('_token'))) {
            $restaurant->setIsDeleted(1);
            $emi->persist($restaurant);
            $emi->flush();   
            $this->addFlash('success', "La suppression a bien été effectuée");
            return $this->redirectToRoute('restaurants_admin');
        }
    }

    /**
     * @Route("/admin/add-restaurant", name="add-restaurant")
     * @Route("/admin/edit-restaurant/{id}", name="edit-restaurant", methods="GET|POST")
     */
    public function addUpdateRestaurant(Restaurants $restaurant = null, Request $request, EntityManagerInterface $emi): Response
    {
        if(!$restaurant) {
            $restaurant = new Restaurants();
        }

        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $isModification = !is_null($restaurant->getId());
            $emi->persist($restaurant);   
            $emi->flush();   
            $this->addFlash('success', ($isModification) ? "Restaurant modifié" : "Restaurant ajouté");
            return $this->redirectToRoute('restaurants_admin');
        }

        return $this->render('admin/update_restaurant.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/load-cities", name="admin/load-cities")
     */
    public function loadCities()
    {
        $row = 1;
        $cities = [];
        
        if (($handle = fopen("../scripts/cities.csv", "r")) !== FALSE) 
        {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
            {
                $num = count($data);
                $row++;
                for ($c=0; $c < $num; $c++) 
                {
                    $cities[$row]['zipcode'] = $data[0];
                    $cities[$row]['name'] = $data[1];
                    $cities[$row]['latitude'] = $data[2];
                    $cities[$row]['longitude'] = $data[3];
                }
            }
            fclose($handle);
        }

        return $this->render('admin/load_cities.html.twig', [
            'cities' => $cities,
            'nbCities' => $row
        ]);
    }

    /**
     * @Route("/admin/do-load-cities/{startRow}/{maxRow}", name="admin/do-load-cities")
     */
    public function doLoadCities(EntityManagerInterface $emi, $startRow, $maxRow)
    {
        set_time_limit(0);
        
        $row = 1;
        $cities = new ArrayObject();
        
        if (($handle = fopen("../scripts/cities.csv", "r")) !== FALSE) 
        {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
            {
                if($row <= $maxRow && $row > ($startRow))
                {
                    $city = new Cities();
                    $city->setName($data[1])->setZipcode($data[0])->setLatitude($data[2])->setLongitude($data[3]);
                    $emi->persist($city);

                    $cities->append($city);
                    
                    if($row == $maxRow )
                    {
                        $emi->flush(); 
                        break; 
                    }
                    else
                    {
                        $row++; 
                    }                       
                }
                else
                {
                    $row++;
                }
            }
            fclose($handle);
        }

        return $this->render('admin/add_city_render.html.twig', [
            'cities' => $cities,
        ]);
    }
}
