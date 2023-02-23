<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'userId',
        'title',
        'body'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(UserApi::class, 'id', 'userId');
    }
}
