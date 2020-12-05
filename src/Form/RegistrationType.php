<?php

/**
 * RegistrationType
 * formulaire d'enregistrement pour producer et customer
 * php version 7.2.5
 *
 * @category   Form
 * @package    Producteurauconsommateur
 * @subpackage App\Form
 * @author     Bernard Thomas <ynofmys@gmail.com>
 * @copyright  2020 Bernard Thomas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @version    GIT: feature/registration
 * @link       http://producteurauconsommateur.com/
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RegistrationType
 * formulaire d'enregistrement pour producer et customer
 *
 * @category Form
 * @package  App\Form
 * @author   Bernard Thomas <ynofmys@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://producteurauconsommateur.com/
 */
class RegistrationType extends AbstractType
{
    /**
     * Défini le formulaire
     *
     * @param FormBuilderInterface $builder builder
     * @param array                $options options
     *
     * @return RegistrationType
     */
    public function buildForm(FormBuilderInterface $builder, array $options): RegistrationType
    {
        $builder

            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class);

        return $this;
    }

    /**
     * Configuration des variables passées au formulaire
     *
     * @param OptionsResolver $resolver ajoute ces options aux options par défaut
     *
     * @return RegistrationType
     */
    public function configureOptions(OptionsResolver $resolver): RegistrationType
    {
        $resolver->setDefaults(
            [
            'data_class' => User::class,
            ]
        );

        return $this;
    }
}
