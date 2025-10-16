<?php

declare(strict_types=1);

namespace App\Controller\Cars;

use App\Entity\Car;
use App\Form\CarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cars/add', name: 'car_add', methods: ['GET', 'POST'])]
final class CarCreateAction extends AbstractController
{
    public function __invoke(Request $request, EntityManagerInterface $em): Response
    {
        $car  = new Car();

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $monthly = $form->get('monthlyPrice')->getData();
            $daily = $form->get('dailyPrice')->getData();

            $car->setMonthlyPrice($monthly * 100);
            $car->setDailyPrice($daily * 100);

            $em->persist($car);
            $em->flush();

            $this->addFlash('success', 'Voiture ajoutée.');

            return $this->redirectToRoute('home');
        }

        return $this->render('car/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
