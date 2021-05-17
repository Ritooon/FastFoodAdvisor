<?php

namespace App\Controller;

use App\Repository\RestaurantsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    /**
     * @Route("/map", name="map")
     */
    public function displayMap(): Response
    {
        return $this->render('map/map.html.twig');
    }

    /**
     * @Route("/get-markers/{latMax}/{longMax}", name="get-markers")
     */
    public function getMarkers($latMax, $longMax, RestaurantsRepository $repo, SerializerInterface $serializer): Response
    {
        $markers = $repo->getMarkers($latMax, $longMax);

        $json = $serializer->serialize($markers, 'json', ['groups' => ['list_markers']]);
        $json = json_decode($json);

        return $this->json($json);
    }
}
