<?php

/**
 * User
 * surchargée par Customer et Producer dans table user avec disc
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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * espace de mémoire user
 *
 * @category                   Entity
 * @package                    App\Entity
 * @author                     Bernard Thomas <ynofmys@gmail.com>
 * @license                    http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link                       http://producteurauconsommateur.com/
 * @ORM\Entity
 * @ORM\InheritanceType(
 *     "SINGLE_TABLE"
 * )
 * @ORM\DiscriminatorColumn(
 *     name="discr",
 *     type="string"
 * )
 * @ORM\DiscriminatorMap({
 *     "producer"="App\Entity\Producer",
 *     "customer"="App\Entity\Customer"
 * })
 * @UniqueEntity("email")
 * @ORM\Table(schema="public")
 */
abstract class User implements UserInterface
{
    /**
     * Identifiant unique
     *
     * @var                     Uuid
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    protected $id;

    /**
     * Prénom
     *
     * @var             string
     * @ORM\Column
     * @Assert\NotBlank
     */
    protected $firstName = "";

    /**
     * Nom de famille
     *
     * @var             string
     * @ORM\Column
     * @Assert\NotBlank
     */
    protected $lastName = "";

    /**
     * Courriel
     *
     * @var                     string
     * @ORM\Column(unique=true)
     * @Assert\NotBlank
     * @Assert\Email
     */
    protected $email = "";

    /**
     * Mot de passe crypté
     *
     * @var        string
     * @ORM\Column
     */
    protected $password = "";

    /**
     * Mot de passe  en clair
     *
     * @var                    string|null
     * @Assert\NotBlank
     * @Assert\Length(min="8")
     */
    protected $plainPassword = null;
    /**
     * Date d'inscription
     *
     * @var                                   DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    protected $registeredAd;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->registeredAd = new DateTimeImmutable();
    }

    /**
     * Getter id
     *
     * @return Uuid
     */
    public function getIid(): Uuid
    {
        return $this->id;
    }

    /**
     * Setter id
     *
     * @param Uuid $id identifiant unique
     *
     * @return User
     */
    public function setId(Uuid $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Getter prénom
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Setter Prénom
     *
     * @param string $firstName Prénom
     *
     * @return User
     */
    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Getter nom de famille
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Setter nom de famille
     *
     * @param string $lastName nom de famille
     *
     * @return User
     */
    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Getter courriel
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Setter courriel
     *
     * @param string $email courriel
     *
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Getter mot de passe en clair
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Setter mot de passe en clair
     *
     * @param string $password mot de passe en clair
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Getter mot de passe crypté
     *
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * Setter mot de passe crypté
     *
     * @param string|null $plainPassword mot de passe crypté
     *
     * @return User
     */
    public function setPlainPassword(?string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Getter date inscription
     *
     * @return DateTimeImmutable
     */
    public function getRegisteredAd(): DateTimeImmutable
    {
        return $this->registeredAd;
    }

    /**
     * Setter date inscription
     *
     * @param DateTimeImmutable $registeredAd date inscription non modifiable
     *
     * @return User
     */
    public function setRegisteredAd(DateTimeImmutable $registeredAd): User
    {
        $this->registeredAd = $registeredAd;

        return $this;
    }

    /**
     * Getter Sel inutile
     *
     * @return string|void|null
     */
    public function getSalt()
    {
    }

    /**
     * Setter sel inutile
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Efface le mot de passe crypté
     *
     * @return UserInterface
     */
    public function eraseCredentials(): UserInterface
    {
        $this->plainPassword = null;

        return $this;
    }
}
