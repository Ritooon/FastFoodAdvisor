<?php

namespace App\Form;

use App\Entity\Cities;
use App\Entity\Restaurants;
use App\Form\DataTransformer\CitiesTransformer;
use App\Repository\CitiesRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RestaurantType extends AbstractType
{
    private $transformer;

    public function __construct(CitiesTransformer $transformer)
    {
        $this->transformer = $transformer;
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
            // ->add('city', EntityType::class, [
            //     'class' => Cities::class,
            //     'query_builder' => function (CitiesRepository $cr) {
            //         return $cr->createQueryBuilder('c')
            //             ->orderBy('c.name', 'ASC');
            //     },
            //     'choice_label' => function(Cities $city) {
            //         return $city->getName().' ('.$city->getZipcode().')';
            //     }
            // ])
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
