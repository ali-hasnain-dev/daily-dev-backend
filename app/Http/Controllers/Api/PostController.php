<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->orderByDesc("id")->cursorPaginate(20);
        return response()->json(['message' => 'Posts fetched successfully', 'posts' => $posts], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $payload = $request->validated();
        try {
            $user = $request->user();
            $payload['user_id'] = $user->id;
            $post = Post::create($payload);
            return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
        } catch (\Exception $th) {
            Log::info('Post error while creating: ' . $th->getMessage());
            return response()->json(['message' => 'Something went wrong try again later'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
