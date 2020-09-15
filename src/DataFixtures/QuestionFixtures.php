<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Question;
use App\Entity\Reponse;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class QuestionFixtures extends Fixture
{

    public function __construct()
    {
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
 

        $typeQuestion=['cs','cm','ct'];
            for($i=1;$i<=25;$i++)
            {
                $question= new Question();
                $type=$faker->randomElement($typeQuestion);
                $question->setLibelle("ma question $i ...........................!!!")
                         ->setType($type)
                         ->setScore($faker->numberBetween($min = 1, $max = 10));
                if($type=="cs" || $type=="cm")
                {
                    $numberQuestion=$faker->numberBetween($min = 2, $max = 5);
                    $maxReponseVrai=$faker->numberBetween($min = 1, $max = ($numberQuestion-1));
                    
                    for($j=1;$j<=$numberQuestion;$j++)
                    {
                        $isCorrect=false;
                        if($maxReponseVrai<=$i)
                        {
                            $isCorrect=true;
                        }
                        $reponse=new Reponse();   
                        $reponse->setLibeller("Q$i Reponse$j...............")
                                 ->setIsCorrect($isCorrect)
                                 ->setQuestion($question);
                        $manager->persist($reponse);
                    }
                }
                else
                {
                    $reponse=new Reponse();   
                    $reponse->setLibeller("Q$i Reponse...............")
                             ->setIsCorrect(true)
                             ->setQuestion($question);
                    $manager->persist($reponse);
                }
            $manager->persist($question);

            }


            

        $manager->flush();
    }
}
