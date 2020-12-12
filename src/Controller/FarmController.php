<?php

namespace App\Controller;

use App\Form\FarmType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FarmController
 * @package App\Controller
 * @Route("/farm", name="farm")
 * @IsGranted("ROLE_PRODUCER")
 */
class FarmController extends AbstractController
{
    /**
     * Met à jour la ferme
     *
     * @Route("/update", name="_update")
     *
     * @param Request $request Object Request
     *
     * @return Response
     */
    public function update(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FarmType::class, $this->getUser()->getFarm())->handleRequest($request);
        if ($form-> isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Votre exploitation est enregistrée.'
            );
            return $this->redirectToRoute('farm_update');
        }
        return $this->render('ui/farm/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
