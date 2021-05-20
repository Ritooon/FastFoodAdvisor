<?php

namespace App\Entity;
use App\Entity\Cities;
use Symfony\Component\Validator\Constraints as Assert;

class SearchRestaurant {
    
    private $name;
    private $city;

    public function getName() 
    {
        return $this->name;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }
    
    public function setCity(?Cities $city)
    {
        $this->city = $city;

        return $this;
    }
}