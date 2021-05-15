<?php

namespace App\Controller;

use App\Repository\CitiesRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CityController extends AbstractController
{
    /**
     * @Route("/get-cities-by-name-or-zipcode/{input}", name="city", methods="GET|POST")
     */
    public function getCityByNameOrZipcode(CitiesRepository $repo, $input, SerializerInterface $serializer): Response
    {
        $cities = $repo->getCitiesByNameOrZipCode($input, 5);
        $json = $serializer->serialize($cities, 'json', ['groups' => 'list_cities']);
        $json = json_decode($json);

        return $this->json($json);
    }
}
