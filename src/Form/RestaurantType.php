<?php

namespace App\Form;

use App\Entity\Cities;
use App\Entity\Restaurants;
use App\Repository\CitiesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Routing\RouterInterface;
use App\Form\DataTransformer\CitiesTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RestaurantType extends AbstractType
{
    private $transformer;
    private $router;

    public function __construct(CitiesTransformer $transformer, RouterInterface $router)
    {
        $this->transformer = $transformer;
        $this->router = $router;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('email')
            ->add('phone')
            ->add('latitude')
            ->add('longitude')
            ->add('pictureFile', FileType::class, ['required'=>false])
            ->add('isApproved')
            ->add('city', TextType::class, [
                'invalid_message' => 'Cette ville n\'existe pas',
            ])
        ;

        $builder->get('city')
            ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurants::class,
        ]);
    }
}
