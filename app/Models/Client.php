<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Client extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'client';

    public $timestamps = false;

    protected $fillable = [
        'full_name', 'phone', 'email', 'birthday', 'address', 'note'
    ];
}
