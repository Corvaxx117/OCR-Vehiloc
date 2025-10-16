<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;

#[Route('/', name: 'home', methods: ['GET'])]
final class HomeAction extends AbstractController
{
    public function __invoke(CarRepository $carRepository): Response
    {
        $cars = $carRepository->findBy([], ['id' => 'DESC']);

        return $this->render('car/index.html.twig', [
            'cars' => $cars,
        ]);
    }
}
