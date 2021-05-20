<?php

namespace App\Form;

use App\Entity\SearchRestaurant;
use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\CitiesTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchRestaurantType extends AbstractType
{
    private $transformer;

    public function __construct(CitiesTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                "label" => "Nom du restaurant"
            ])
            ->add('city', TextType::class, [
                'required' => false,
            ])
        ;

        $builder->get('city')
            ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchRestaurant::class,
        ]);
    }
}