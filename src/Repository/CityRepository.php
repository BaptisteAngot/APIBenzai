<?php

namespace App\Repository;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registery, EntityManagerInterface $manager)
    {
        parent::__construct($registery, City::class);
        $this->manager = $manager;
    }

    public function saveCity($name,$county_code,$region,$mail_city)
    {
        $newCity = new City();

        //vérification intégrité et validité des données
        empty($name) ? true : $newCity->setName($name);
        empty($county_code) ? true : $newCity->setCountyCode($county_code);
        empty($region) ? true : $newCity->setRegion($region);
        empty($mail_city) ? true : $newCity->setMailCity($mail_city);

        $this->manager->persist($newCity);
        $this->manager->flush();
    }

    public function updateCity(City $city, $data)
    {
        //vérification intégrité et validité des données
        empty($data['name']) ? true : is_string($data['name']) ? true : strlen($data['name']) > 100 ? true : $city->setName($data['name']);
        empty($data['countyCode']) ? true : is_string($data['countyCode']) ? true : strlen($data['countyCode']) > 10 ? true : $city->setCountyCode($data['countyCode']);
        empty($data['region']) ? true : is_string($data['region']) ? true : strlen($data['region']) > 100 ? true : $city->setRegion($data['region']);
        empty($data['mailCity']) ? true : is_string($data['mailCity']) ? true : strlen($data['mailCity']) > 150 ? true : $city->setMailCity($data['mailCity']);
        $city->setUpdatedAt(new \Datetime("now"));
        $this->manager->flush();
    }

    public function removeCity(City $city)
    {
        //auth admin stp

        $this->manager->remove($city);
        $this->manager->flush();
    }

}