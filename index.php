<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\UserAddress;

$userAddress = new UserAddress();

echo $userAddress->getTable();
