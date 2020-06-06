<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Personne;
use App\Entity\Post;
use App\Entity\Reclamation;
use App\Entity\Seance;
use App\Entity\Ville;
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
        $this->loadVille($manager);
        $this->loadImage($manager);
        $this->loadPersonnes($manager);

        $this->loadPost($manager);
        $this->loadComment($manager);
        $this->loadReclamation($manager);

        $manager->flush();
    }


    public function loadVille(ObjectManager $manager)
    {
        for ($i = 0; $i < 30; $i++) {
            $ville = new Ville();
            $ville->setLibele($this->faker->city);
            $this->addReference("city_$i", $ville);
        }
        $manager->flush();
    }
    public function loadImage(ObjectManager $manager)
    {

        for ($i = 0; $i < 200; $i++) {
            $image = new Image();
            $image->setUrl("user_image.png");
            $this->addReference("image_$i", $image);
        }
        $manager->flush();
    }
    public function loadPersonnes(ObjectManager $manager)
    {

        for ($i = 0; $i < 50; $i++) {

            $myUser = new Personne();
            $myUser->setNom($this->faker->lastName);
            $myUser->setPrenom($this->faker->firstName);
            $myUser->setAdresse($this->faker->address);
            $myUser->setNumTelephone($this->faker->phoneNumber);
            $myUser->setPassword($this->passwordEncoder->encodePassword(
                $myUser,
                'secret'
            ));
            $ville = $this->getReference("city_" . rand(0, 29));
            $myUser->setVille($ville);

            $image = $this->getReference("image_" . rand(0, 199));
            $myUser->setImage($image);

            $myUser->setEmail($this->faker->email);

            $roles = ['ROLE_DEMANDEUR', 'ROLE_VOLENTAIRE', 'ROLE_ADMIN'];

            $myUser->setRoles([$roles[rand(0, 2)]]);

            $manager->persist($myUser);

            $this->addReference("user_$i", $myUser);
        }


        $manager->flush();
    }


    public function loadPost(ObjectManager $manager)
    {
        for ($i = 0; $i < 500; $i++) {
            $post = new Post();
            $post->setTitle("Post title");
            $post->setContent($this->faker->text);
            $post->setPublished($this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null));

            $types = ['DEMANDE', 'VOLONTARIAT'];

            $post->setType($types[rand(0, 1)]);
            $user = $this->getReference("user_" . rand(0, 49));
            $post->setAuthor($user);

            $ville = $this->getReference("city_" . rand(0, 29));
            $post->setVille($ville);

            $manager->persist($post);

            $this->addReference("post_$i", $post);
        }
        $manager->flush();
    }
    public function loadComment(ObjectManager $manager)
    {
        for ($i = 0; $i < 1500; $i++) {
            $comment = new Comment();
            $comment->setContent($this->faker->text);
            $user = $this->getReference("user_" . rand(0, 49));
            $comment->setAuthor($user);
            $post = $this->getReference("post_" . rand(0, 499));
            $comment->setPost($post);
            $manager->persist($comment);

            $this->addReference("comment_$i", $comment);
        }
        $manager->flush();
    }

    public function loadReclamation(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $reclamation = new Reclamation();
            $reclamation->setObjet($this->faker->title);
            $reclamation->setContenu($this->faker->text);

            $post = $this->getReference("post_" . rand(0, 499));
            $reclamation->setPost($post);
            $user = $this->getReference("user_" . rand(0, 49));
            $reclamation->setUser($user);
            $manager->persist($reclamation);

            $this->addReference("reclamation_$i", $reclamation);
        }
        $manager->flush();
    }
}
