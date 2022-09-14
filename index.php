<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\User;

$user = new User();

$user->fill([
    'first_name' => 'Lucas',
    'last_name' => 'Mendes',
    'email' => 'lucas@mail.com'
]);
