<?php

/**
 * Class SecurityController
 * controlleur d'enregistrement pour producer et customer
 * php version 7.2.5
 *
 * @category   Controller
 * @package    Producteurauconsommateur
 * @subpackage App\Controller
 * @author     Bernard Thomas <ynofmys@gmail.com>
 * @copyright  2020 Bernard Thomas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @version    GIT: feature/registration
 * @link       http://producteurauconsommateur.com/
 */

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Producer;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Class SecurityController
 * controlleur d'enregistrement pour producer et customer
 *
 * @category Controller
 * @package  App\Controller
 * @author   Bernard Thomas <ynofmys@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://producteurauconsommateur.com/
 */
class SecurityController extends AbstractController
{
    /**
     * Enregistrement d'un Customer ou d'un Producer
     *
     * @Route("/registration/{role}", name="registration")
     *
     * @param string                       $role                customer ou producer
     * @param Request                      $request             Request
     * @param EntityManagerInterface       $entityManager       EntityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder UserPasswordEncoder
     *
     * @return Response
     */
    public function registration(string $role, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        $user = Producer::ROLE === $role ? new Producer() : new Customer();
        $user->setId(Uuid::v4());
        $form = $this->createForm(RegistrationType::class, $user)
            ->handleRequest($request);
        if ($form-> isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordEncoder
                    ->encodePassword($user, $user->getPlainPassword())
            );
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Votre inscription est enregistrée.'
            );

            return $this->redirectToRoute('index');
        }

        return $this->render(
            'ui/security/registration.html.twig',
            ['form' => $form->createView()]
        );
    }
}
