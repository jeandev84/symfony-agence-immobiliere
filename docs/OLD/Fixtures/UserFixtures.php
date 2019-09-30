<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{


    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        # Creer un nouveau utilisateur
        $user = new User();

        # definit un nouveau utilisateur
        $user->setUsername('demo');

        # definit un nouveau password
        # la methode encodePassword prend toujours en premier parametre qui implemente la UserInterface
        #  le mot de passe dont on souhaie encoder
        $cryptedPass = $this->encoder->encodePassword($user, 'demo');
        $user->setPassword($cryptedPass);

        $manager->persist($user);
        $manager->flush();
    }

    /*
     public function load(ObjectManager $manager)
     {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
     }
     */
}
