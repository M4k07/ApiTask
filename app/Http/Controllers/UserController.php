<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\UserApi;
use Illuminate\Http\Request;
use App\Services\ApiDataService;
class UserController extends Controller
{
    protected $apiDataService;
    
    public function __construct(ApiDataService $apiDataService){
        $this->apiDataService = $apiDataService;
    }
    public function index()
    {
        // Retrieve all users and their posts from database
        $users = UserApi::with('posts')->get();

        return view('users.index', compact('users'));
    }

    public function syncUsers()
    {
        // Retrieve users and posts data from external API and store in models
        $this->apiDataService->getUsersAndPosts();

        return redirect()->route('users.index')->with('success', 'Users data synced successfully');
    }
    // public function index(){
    //     return 'test';
    // }
}
