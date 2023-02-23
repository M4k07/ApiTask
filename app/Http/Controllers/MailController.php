<?php

namespace App\Http\Controllers;

use App\Mail\OldestPosts;
use App\Models\UserApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index()
    {
        $users = UserApi::with('posts')->get();
        $mailData = '';
        foreach ($users as $user) {
            $mailData .= "\n {$user->name} has written \n";
            foreach ($user->posts->sortBy('posts.id')->take(3) as $post) {
                $mailData .= "Title: {$post->title} \n";
                $mailData .= "Body: {$post->body} \n";
            }
        }
        // dd(env);
        dd($mailData);

        Mail::to('test@test.com')->send(new OldestPosts($mailData));
    }
}
