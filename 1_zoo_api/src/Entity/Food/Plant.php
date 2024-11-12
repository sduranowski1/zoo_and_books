<?php

namespace App\Entity\Food;

use App\Interface\Food;

class Plant implements Food {
    public function getType(): string {
        return 'Plant';
    }
}
