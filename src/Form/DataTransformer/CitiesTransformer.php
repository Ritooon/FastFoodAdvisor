<?php
namespace App\Form\DataTransformer;

use App\Entity\Cities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CitiesTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (cities) to a string (number).
     *
     * @param  Cities|null $city
     */
    public function transform($city): string
    {
        if (null === $city) {
            return '';
        }

        $cityNameZip = $city->getName().' ('.$city->getZipcode().')';

        return $cityNameZip;
    }

    /**
     * Transforms a string (number) to an object (city).
     *
     * @param  string $cityNameZip
     * @throws TransformationFailedException if object (city) is not found.
     */
    public function reverseTransform($cityNameZip): ?Cities
    {
        if (!$cityNameZip) {
            return null;
        }

        $cityNameZip = trim($cityNameZip);

        $name = trim(substr($cityNameZip, 0, strpos($cityNameZip, '(')));
        $zipcode = trim(substr($cityNameZip, strpos($cityNameZip, '(')+1));
        $zipcode = substr($zipcode, 0, strlen($zipcode)-1);

        $city = $this->entityManager
            ->getRepository(Cities::class)
            ->findOneBy(['name' => $name, 'zipcode' => $zipcode])
        ;

        if (null === $city) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An city with id "%s" does not exist!',
                $cityNameZip
            ));
        }

        return $city;
    }
}