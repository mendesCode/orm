<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Planet;

Planet::all(['planet_id', 'name', 'type'], [
    'where' => [
        'star_id IS NOT NULL',
        'planet_id' => 2,
        'name' => 'Earth'
    ]
]);