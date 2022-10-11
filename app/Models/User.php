<?php

namespace App\Models;

use App\ORM\Model;

class User extends Model
{
    protected array $fillable = ['first_name'];

    protected array $guarded = ['first_name', 'last_name'];
}
