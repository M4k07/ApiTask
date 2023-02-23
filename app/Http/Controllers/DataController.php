<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\UserApi;
use App\Models\Post;

class DataController extends Controller
{
    /**
     * Import data from API endpoints and store in database
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *      path="/api/import-data",
     *      tags={"Data Import"},
     *      summary="Import data from API endpoints",
     *      description="This endpoint imports data from two external API endpoints and stores it in the database",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="Data imported successfully"
     *      )
     * )
     */
    public function store()
    {
        $client = new Client();
        $response = $client->get(env('API_URL_USER'));
        $users = json_decode($response->getBody());

        foreach ($users as $user) {
            UserApi::updateOrCreate([
                'id' => $user->id
            ], [
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
            ]);
        }

        $response = $client->get(env('API_URL_POST'));
        $posts = json_decode($response->getBody());

        foreach ($posts as $post) {
            $user = UserApi::where('id', $post->userId)->first();
            if ($user) {
                $user->posts()->updateOrCreate([
                    'id' => $post->id
                ], [
                    'title' => $post->title,
                    'body' => $post->body,
                ]);
            }
        }

        return response()->json(['message' => 'Data imported successfully!']);
    }
}
