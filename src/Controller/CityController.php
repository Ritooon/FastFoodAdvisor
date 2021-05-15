<?php

namespace App\Controller;

use App\Repository\CitiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    /**
     * @Route("/get-cities-by-name-or-zipcode/{input}", name="city", methods="GET|POST")
     */
    public function getCityByNameOrZipcode(CitiesRepository $repo, $input): Response
    {
        $cities = $repo->getCitiesByNameOrZipCode($input, 5);
        return $this->json($cities);
    }
}
