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

    public function mapPostDataResponse($response){
        $this->id = $response['id'];
        $this->userId = $response['userId'];
        $this->title = $response['title'];
        $this->body = $response['body'];
    }
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(UserApi::class,'id','userId');
    }
}
