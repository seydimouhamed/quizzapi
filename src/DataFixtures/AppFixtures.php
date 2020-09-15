<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
            $profilJ=new Role();
            $profilJ->setLibelle('JOUEUR');
            $manager->persist($profilJ);
            $profilA=new Role();
            $profilA->setLibelle('ADMIN');
            $manager->persist($profilA);

            for($i=1;$i<=10;$i++)
            {
                $user=new User();
                $user->setUsername('player'.$i);
                $user->setFirstname("prenom_".$i);
                $user->setLastname("nom_".$i);
                $user->setProfil($profilJ);
                $user->setAvatar(fopen($faker->imageUrl($width=100,$height=100),"rb"));
                $pwd=$this->encoder->encodePassword($user,"passe123");
                $user->setPassword($pwd);

            $manager->persist($user);

            }

            for($i=1;$i<=3;$i++)
            {
                $user=new User();
                $user->setUsername('admin'.$i)
                    ->setFirstname("admin_prenom_".$i)
                    ->setLastname("admin_nom_".$i)
                    ->setProfil($profilA)
                    ->setAvatar(fopen($faker->imageUrl($width=100,$height=100),"rb"));

                $pwd=$this->encoder->encodePassword($user,"passe123");
                $user->setPassword($pwd);
                $manager->persist($user);
            }

            

        $manager->flush();
    }
}
