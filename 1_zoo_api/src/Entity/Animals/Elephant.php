<?php

namespace App\Entity\Animals;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Animals\ElephantController;
use App\Entity\Food\Plant;
use App\Interface\Food;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Animal;

#[ORM\Entity]
#[ApiResource(    operations: [
    new Post(
        uriTemplate: '/elephant/{id}/eat', // Custom path for eating action
        controller: ElephantController::class . '::eat', // Link to the eat method in elephantController
        openapi: new \ApiPlatform\OpenApi\Model\Operation(
            summary: 'Feed the elephant',
            description: 'This endpoint feeds the elephant identified by its ID with the specified food.',
        ),
    )
],)]
#[ApiResource]
class Elephant extends Animal {
    public function getSpecies(): string {
        return 'Elephant';
    }

    public function eat(Food $food): string {
        if ($food instanceof Plant) {
            return $this->name . " is eating plants.";
        }
        return $this->name . " only eats plants!";
    }
}
