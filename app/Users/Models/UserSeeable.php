<?php namespace App\Users\Models;

use Illuminate\Database\Eloquent\Model;

class UserSeeable extends Model
{
    protected $table = 'users_seeable';
    protected $fillable = [
        'seeable_type',
        'seeable_id',
    ];
}
