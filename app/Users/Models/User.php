<?php namespace App\Users\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'api_token',
        'facebook_id',
    ];
}
