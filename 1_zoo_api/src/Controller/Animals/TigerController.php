<?php

namespace App\Controller\Animals;

use App\Entity\Animal;
use App\Entity\Animals\Tiger;
use App\Entity\Food\Meat;
use App\Entity\Food\Plant;
use App\Interface\Food;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TigerController extends AbstractController {
    #[Route('/api/tiger/{id}/brush', name: 'tiger_brush', methods: ['POST'])]
    public function brush(int $id, EntityManagerInterface $entityManager): JsonResponse {
        // Retrieve the animal by ID
        $animal = $entityManager->getRepository(Animal::class)->find($id);

        // Check if the animal is a Tiger
        if (!$animal instanceof Tiger) {
            throw new BadRequestHttpException("This is not a Tiger!");
        }

        // Call the brush method on the Tiger object
        $message = $animal->brush();

        // Return a response without needing a request body
        return new JsonResponse(['message' => $message]);
    }

    #[Route('/api/tiger/{id}/eat', name: 'tiger_eat', methods: ['POST'])]
    public function eat(Request $request, Tiger $tiger): JsonResponse {
        // Extract food information from request
        $data = json_decode($request->getContent(), true);
        $foodType = $data['foodType'] ?? '';

        // Assume Meat food type for simplicity
        if ($foodType === 'meat') {
            $food = new Meat();
        } elseif ($foodType === 'plant') {
            $food = new Plant(); // Make sure you have this class defined and it implements Food
        } else {
            throw new BadRequestHttpException("Invalid food type provided");
        }

        // Call the eat method from the Tiger entity
        $message = $tiger->eat($food);

        return new JsonResponse(['message' => $message]);
    }

}