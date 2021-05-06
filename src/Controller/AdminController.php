<?php

namespace App\Controller;

use ArrayObject;
use App\Entity\Cities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
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
