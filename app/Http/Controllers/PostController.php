<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return $posts;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validatorsDatas = $request->validated();
        $request->user()->posts()->create($validatorsDatas);
        return response(["message" => "The post is created successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized: you are not the owner of this post!'], 403);
        }

        $validatorsDatas = $request->validated();
        $post->update($validatorsDatas);
        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (Auth::user()->id !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized: You are not the owner of this post!'], 403);
        }
        $post->delete();
        return response(['message', "the post is successfully deleted"]);
    }
}
