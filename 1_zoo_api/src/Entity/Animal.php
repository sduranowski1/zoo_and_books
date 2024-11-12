<?php

// src/Entity/Animals/Animal.php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap([
    "tiger" => "App\Entity\Animals\Tiger",
    "elephant" => "App\Entity\Animals\Elephant",
    "rhinoceros" => "App\Entity\Animals\Rhinoceros",
    "fox" => "App\Entity\Animals\Fox",
    "snow_leopard" => "App\Entity\Animals\SnowLeopard",
    "rabbit" => "App\Entity\Animals\Rabbit"
])]
#[ApiResource] // Ensure this is here
abstract class Animal {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    protected string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    abstract public function getSpecies(): string;

    public function __toString(): string {
        return $this->getSpecies() . ' ' . $this->name;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }
}


