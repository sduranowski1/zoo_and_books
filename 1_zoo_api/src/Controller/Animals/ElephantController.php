<?php

namespace App\Controller\Animals;

use App\Entity\Animal;
use App\Entity\Animals\Elephant;
use App\Entity\Food\Meat;
use App\Entity\Food\Plant;
use App\Interface\Food;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ElephantController extends AbstractController {
    #[Route('/api/elephant/{id}/eat', name: 'elephant_eat', methods: ['POST'])]
    public function eat(Request $request, Elephant $elephant): JsonResponse {
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

        // Call the eat method from the Elephant entity
        $message = $elephant->eat($food);

        return new JsonResponse(['message' => $message]);
    }

}
