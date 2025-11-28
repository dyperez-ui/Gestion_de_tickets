<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auttoken extends Model
{
    protected $table = 'auth_tokens';

    protected $fillable = ['user_id', 'token'];

    public $timestamps = true;
}
