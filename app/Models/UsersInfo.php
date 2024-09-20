<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersInfo extends Model
{
    use HasFactory;

    protected $table = 'users_info';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'contact',
        'address'
    ];
}
