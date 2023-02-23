<?php

namespace App\Http\Controllers;

use App\Mail\OldestPosts;
use App\Models\UserApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
     /**
     * @OA\Post(
     *     path="/api/send-email",
     *     summary="Send email with oldest posts for each user",
     *     @OA\Response(
     *         response="200",
     *         description="Email sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email Sent")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Could not send email",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Could not send email")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $users = UserApi::with('posts')->get();
        $mailData = '';
        foreach ($users as $user) {
            $mailData .= "\n {$user->name} has written \n";
            foreach ($user->posts->sortBy('posts.id')->take(3) as $post) {
                $mailData .= "\n-Title: {$post->title} \n";
                $mailData .= "\n--Body: {$post->body} \n";
            }
        }
        // dd(env);
        // dd(print_r($mailData,true));

        try {
            Mail::to('test@test.com')->send(new OldestPosts($mailData));
            return response()->json(['message' => 'Email Sent']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not send email'], 500);
        }
        
    }
}
