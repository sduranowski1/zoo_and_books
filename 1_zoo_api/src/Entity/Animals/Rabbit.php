<?php
namespace App\Entity\Animals;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Animals\RabbitController;
use App\Entity\Food\Plant;
use App\Interface\Food;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Animal;
use App\Interface\BrushableInterface;

#[ORM\Entity]
#[ApiResource(    operations: [
    new Post(
        uriTemplate: '/rabbit/{id}/brush', // Custom path for brushing action
        controller: RabbitController::class . '::brush', // No input body is expected in the request
        openapi: new \ApiPlatform\OpenApi\Model\Operation(
            summary: 'Brush a rabbit',
            description: 'This endpoint allows you to brush any rabbit',
            requestBody: null
        ),

    ),
    new Post(
        uriTemplate: '/rabbit/{id}/eat', // Custom path for eating action
        controller: RabbitController::class . '::eat', // Link to the eat method in rabbitController
        openapi: new \ApiPlatform\OpenApi\Model\Operation(
            summary: 'Feed the rabbit',
            description: 'This endpoint feeds the rabbit identified by its ID with the specified food.',
        ),
    )
],)]
#[ApiResource]
class Rabbit extends Animal implements BrushableInterface {
    public function getSpecies(): string {
        return 'Rabbit';
    }

    public function brush(): string {
        if (!$this->isBrushable()) {
            return "This animal cannot be brushed!";
        }
        return "Brushing the rabbit's fur";
    }

    public function isBrushable(): bool {
        // Assume that Rabbit's are brushable, but you can customize this logic
        return true;
    }

    public function eat(Food $food): string {
        if ($food instanceof Plant) {
            return $this->name . " is eating plants.";
        }
        return $this->name . " only eats plants!";
    }
}
