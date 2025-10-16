<?php

declare(strict_types=1);

namespace App\Controller\Cars;

use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Suppression d'un véhicule.
 *
 * - Pas d'héritage d'AbstractController, on gère manuellement la Response.
 * - Suppression via identifiant numérique (POST seulement) pour éviter une suppression accidentelle.
 * - Redirection vers la liste après suppression.
 */
#[Route('/cars/{id}/delete', name: 'car_delete', requirements: ['id' => '\\d+'], methods: ['POST'])]
final class CarDeleteAction
{
    public function __construct(
        private readonly CarRepository $repository,
        private readonly EntityManagerInterface $em,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {}

    public function __invoke(int $id, Request $request): Response
    {
        $car = $this->repository->find($id);
        if (!$car) {
            throw new NotFoundHttpException('Véhicule introuvable');
        }

        $this->em->remove($car);
        $this->em->flush();

        return new RedirectResponse($this->urlGenerator->generate('home'));
    }
}
