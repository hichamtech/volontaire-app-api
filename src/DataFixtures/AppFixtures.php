<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use App\Entity\Seance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public $faker;
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->faker = Factory::create();
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $this->loadPersonnes($manager);
        $this->loadSeance($manager);

        $manager->flush();
    }

    public function loadPersonnes(ObjectManager $manager)
    {

        for ($i = 0; $i < 50; $i++) {

            $myUser = new Personne();
            $myUser->setNom($this->faker->lastName);
            $myUser->setPrenom($this->faker->firstName);
            $myUser->setCIN($this->faker->bothify('?#?#?###'));
            $myUser->setDateNaissance($this->faker->dateTime);
            $myUser->setAdresse($this->faker->address);
            $myUser->setNumTelephone($this->faker->phoneNumber);
            $myUser->setPassword($this->passwordEncoder->encodePassword(
                $myUser,
                'secret'
            ));

            $myUser->setEmail($this->faker->email);

            $roles = ['ROLE_CLIENT', 'ROLE_MONITEUR', 'ROLE_ADMIN'];

            $myUser->setRoles([$roles[rand(0, 2)]]);

            $manager->persist($myUser);

            $this->addReference("user_$i", $myUser);
        }


        $manager->flush();
    }

    public function loadSeance(ObjectManager $manager)
    {
        for ($i = 0; $i < 1000; $i++) {

            $seance = new Seance();

            $seance->setDateDebut($this->faker->dateTime);
            $seance->setDateFin($this->faker->dateTime);

            $seance->setNbrRep($this->faker->numberBetween(1, 6));


            $user = $this->getReference("user_" . rand(0, 49));
            $seance->setPersonne($user);
            $manager->persist($seance);
        }


        $manager->flush();
    }
}
