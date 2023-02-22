<?php

namespace App\Services;

use App\Models\UserApi;
use App\Models\Post;
use Illuminate\Support\Facades\Http;

class ApiDataService {
    public function getUsersAndPosts(){
        $usersResponse = Http::get(env('API_URL_USER'));
        $postsResponse = Http::get(env('API_URL_POST'));
        
        $usersData = $usersResponse->json();
        $postsData = $postsResponse->json();

        foreach($usersData as $userData){
            $user = new UserApi([
                'id' => $userData['id'],
                'name' =>$userData['name'],
                'username' =>$userData['username'],
                'email' =>$userData['email'],
            ]);
            $user->save();

            $userPostsData = array_filter($postsData,function($post) use ($userData){
                return $post['userId'] == $userData['id'];
            });

            foreach($userPostsData as $post){
                $user->posts()->create([
                    'userId' =>$post['userId'],
                    'id' => $post['id'],
                    'title' => $post['title'],
                    'body' => $post['body']
                ]);
            }
        }
        return $usersData;
    }
}
