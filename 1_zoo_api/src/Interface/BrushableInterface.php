<?php

namespace App\Interface;

interface BrushableInterface {
    public function brush(): string;
    public function isBrushable(): bool;  // Add this method to check if the animal is brushable

}
