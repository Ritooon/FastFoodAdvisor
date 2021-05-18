<?php

namespace App\Form;

use App\Entity\Cities;
use App\Entity\Restaurants;
use App\Repository\CitiesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('email')
            ->add('phone')
            ->add('pictureFile', FileType::class, ['required'=>false])
            ->add('isApproved')
            ->add('city', EntityType::class, [
                'class' => Cities::class,
                'query_builder' => function (CitiesRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => function(Cities $city) {
                    return $city->getName().' ('.$city->getZipcode().')';
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurants::class,
        ]);
    }
}
