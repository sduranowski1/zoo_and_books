<?php

namespace App\Entity\Animals;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Animals\FoxController;
use App\Entity\Food\Meat;
use App\Entity\Food\Plant;
use App\Interface\Food;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Animal;
use App\Interface\BrushableInterface;

#[ORM\Entity]
#[ApiResource(    operations: [
    new Post(
        uriTemplate: '/fox/{id}/brush', // Custom path for brushing action
        controller: FoxController::class . '::brush', // No input body is expected in the request
        openapi: new \ApiPlatform\OpenApi\Model\Operation(
            summary: 'Brush a fox',
            description: 'This endpoint allows you to brush any fox',
            requestBody: null
        ),

    ),
    new Post(
        uriTemplate: '/fox/{id}/eat', // Custom path for eating action
        controller: FoxController::class . '::eat', // Link to the eat method in foxController
        openapi: new \ApiPlatform\OpenApi\Model\Operation(
            summary: 'Feed the fox',
            description: 'This endpoint feeds the fox identified by its ID with the specified food.',
        ),
    )
],)]
#[ApiResource]
class Fox extends Animal implements BrushableInterface {
    public function getSpecies(): string {
        return 'Fox';
    }

    public function brush(): string {
        if (!$this->isBrushable()) {
            return "This animal cannot be brushed!";
        }
        return "Brushing the fox's fur";
    }

    // Implement the isBrushable method
    public function isBrushable(): bool {
        // Assume that Fox's are brushable, but you can customize this logic
        return true;
    }

    public function eat(Food $food): string {
        if ($food instanceof Meat || $food instanceof Plant) {
            return $this->name . " is eating.";
        }
        return $this->name . " eats both meat and plants!";
    }
}
