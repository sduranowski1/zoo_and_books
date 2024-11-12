<?php

namespace App\Entity\Animals;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\AnimalController;
use App\Controller\Animals\TigerController;
use App\Entity\Food\Meat;
use App\Interface\BrushableInterface;
use App\Interface\Food;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Animal;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/tiger/{id}/brush', // Custom path for brushing action
            controller: TigerController::class . '::brush', // No input body is expected in the request
            openapi: new \ApiPlatform\OpenApi\Model\Operation(
                summary: 'Brush a tiger',
                description: 'This endpoint allows you to brush any tiger',
                requestBody: null
            ),

        ),
        new Post(
            uriTemplate: '/tiger/{id}/eat', // Custom path for eating action
            controller: TigerController::class . '::eat', // Link to the eat method in TigerController
            openapi: new \ApiPlatform\OpenApi\Model\Operation(
                summary: 'Feed the tiger',
                description: 'This endpoint feeds the tiger identified by its ID with the specified food.',
            ),
        )
    ],
)]
#[ApiResource()]
class Tiger extends Animal implements BrushableInterface {
    public function getSpecies(): string {
        return 'Tiger';  // Return species name for Tiger
    }

    public function brush(): string {
        if (!$this->isBrushable()) {
            return "This animal cannot be brushed!";
        }
        return "Brushing the tiger's fur";
    }

    // Implement the isBrushable method
    public function isBrushable(): bool {
        // Assume that Tigers are brushable, but you can customize this logic
        return true;
    }

    public function eat(Food $food): string {
        if ($food instanceof Meat) {
            return $this->name . " is eating meat.";
        }
        return $this->name . " only eats meat!";
    }
}
