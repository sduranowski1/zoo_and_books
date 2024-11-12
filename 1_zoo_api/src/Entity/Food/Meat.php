<?php

namespace App\Entity\Food;

use App\Interface\Food;

class Meat implements Food {
    public function getType(): string {
        return 'Meat';
    }
}