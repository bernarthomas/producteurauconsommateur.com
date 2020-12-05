<?php

/**
 * Customer
 * surcharge user dans table user avec disc = customer
 * php version 7.2.5
 *
 * @category   Entity
 * @package    Producteurauconsommateur
 * @subpackage App\Entity
 * @author     Bernard Thomas <ynofmys@gmail.com>
 * @copyright  2020 Bernard Thomas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @version    GIT: feature/registration
 * @link       http://producteurauconsommateur.com/
 */

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Customer
 * espace de mémoire customer
 *
 * @category   Entity
 * @package    App\Entity
 * @author     Bernard Thomas <ynofmys@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link       http://producteurauconsommateur.com/
 * @ORM\Entity
 */
class Customer extends User
{
    /**
     * Role
     *
     * @var string role customer
     */
    public const ROLE = 'customer';

    /**
     * Getter roles
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        return ['ROLE_CUSTOMER'];
    }
}
