<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'username',
        'email',
    ];

    public $timestamps = false;

    public function posts(){
        return $this->hasMany(Post::class,'userId','id');
    }
}
