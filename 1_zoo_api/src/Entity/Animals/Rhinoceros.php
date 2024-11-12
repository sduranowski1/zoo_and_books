<?php

namespace App\Entity\Animals;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Animals\RhinocerosController;
use App\Entity\Food\Plant;
use App\Interface\Food;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Animal;

#[ORM\Entity]
#[ApiResource(    operations: [
    new Post(
        uriTemplate: '/rhinoceros/{id}/eat', // Custom path for eating action
        controller: RhinocerosController::class . '::eat', // Link to the eat method in rhinocerosController
        openapi: new \ApiPlatform\OpenApi\Model\Operation(
            summary: 'Feed the rhinoceros',
            description: 'This endpoint feeds the rhinoceros identified by its ID with the specified food.',
        ),
    )
],)]
#[ApiResource]
class Rhinoceros extends Animal {
    public function getSpecies(): string {
        return 'Rhinoceros';
    }

    public function eat(Food $food): string {
        if ($food instanceof Plant) {
            return $this->name . " is eating plants.";
        }
        return $this->name . " only eats plants!";
    }
}
