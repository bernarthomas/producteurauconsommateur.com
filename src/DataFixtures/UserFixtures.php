<?php

/**
 * UserFixtures
 * Génrération de données de test
 * php version 7.2.5
 *
 * @category   DataFixtures
 * @package    Producteurauconsommateur
 * @subpackage App\DataFixtures
 * @author     Bernard Thomas <ynofmys@gmail.com>
 * @copyright  2020 Bernard Thomas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @version    GIT: feature/registration
 * @link       http://producteurauconsommateur.com/
 */

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Producer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Class UserFixtures
 * Génrération de données de test
 *
 * @category DataFixtures
 * @package  App\DataFixtures
 * @author   Bernard Thomas <ynofmys@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://producteurauconsommateur.com/
 */
class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface Encodeur de mot de passe
     */
    private $userPasswordEncoder;

    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * Charge les données de test
     *
     * @param ObjectManager $manager gestionnaire d'objet
     *
     * @return UserFixtures
     */
    public function load(ObjectManager $manager): UserFixtures
    {
        $producer = new Producer();
        $producer
            ->setId(Uuid::v4())
            ->setPassword($this->userPasswordEncoder->encodePassword($producer, 'password'))
            ->setFirstName('Jane')
            ->setLastName('Doe')
            ->setEmail('producer@email.com')
        ;
        $manager->persist($producer);
        $customer = new Customer();
        $customer
            ->setId(Uuid::v4())
            ->setPassword($this->userPasswordEncoder->encodePassword($producer, 'password'))
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setEmail('customer.com');
        $manager->persist($customer);
        $manager->flush();

        return $this;
    }
}
