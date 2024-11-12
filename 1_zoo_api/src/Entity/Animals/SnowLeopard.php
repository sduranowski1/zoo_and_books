<?php
namespace App\Entity\Animals;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Animals\SnowLeopardController;
use App\Entity\Food\Meat;
use App\Interface\Food;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Animal;
use App\Interface\BrushableInterface;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/snow_leopard/{id}/brush', // Custom path for brushing action
            controller: SnowLeopardController::class . '::brush', // No input body is expected in the request
            openapi: new \ApiPlatform\OpenApi\Model\Operation(
                summary: 'Brush a SnowLeopard',
                description: 'This endpoint allows you to brush any SnowLeopard',
                requestBody: null
            ),

        ),
        new Post(
            uriTemplate: '/snow_leopard/{id}/eat', // Custom path for eating action
            controller: SnowLeopardController::class . '::eat', // Link to the eat method in SnowLeopardController
            openapi: new \ApiPlatform\OpenApi\Model\Operation(
                summary: 'Feed the SnowLeopard',
                description: 'This endpoint feeds the SnowLeopard identified by its ID with the specified food.',
            ),
        )
    ],
)]
#[ApiResource]
class SnowLeopard extends Animal implements BrushableInterface {
    public function getSpecies(): string {
        return 'Snow Leopard';
    }

    public function brush(): string {
        if (!$this->isBrushable()) {
            return "This animal cannot be brushed!";
        }
        return "Brushing the snow leopard's fur";
    }

    public function isBrushable(): bool {
        // Assume that Rabbit's are brushable, but you can customize this logic
        return true;
    }

    public function eat(Food $food): string {
        if ($food instanceof Meat) {
            return $this->name . " is eating meat.";
        }
        return $this->name . " only eats meat!";
    }
}
