<?php

/**
 * AppFixtures
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

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AppFixtures
 * Génrération de données de test
 *
 * @category DataFixtures
 * @package  App\DataFixtures
 * @author   Bernard Thomas <ynofmys@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://producteurauconsommateur.com/
 */
class AppFixtures extends Fixture
{
    /**
     * Charge les données de test
     *
     * @param ObjectManager $manager gestionnaire d'objet
     *
     * @return AppFixtures
     */
    public function load(ObjectManager $manager): AppFixtures
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();

        return $this;
    }
}
