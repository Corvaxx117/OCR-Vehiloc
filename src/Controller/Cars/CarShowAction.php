<?php

namespace App\Controller\Cars;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('/cars/{slug}', name: 'car_show', methods: ['GET'])]
final class CarShowAction extends AbstractController
{
    public function __invoke(string $slug, CarRepository $repository): Response
    {
        $car = $repository->findOneBy(['slug' => $slug]);
        if (!$car) {
            throw new NotFoundHttpException('Véhicule introuvable');
        }
        return $this->render('car/show.html.twig', [
            'car' => $car,
        ]);
    }
}
