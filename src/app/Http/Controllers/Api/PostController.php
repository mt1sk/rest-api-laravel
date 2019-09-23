<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\IndexPostRequest;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;
use App\Http\Resources\Post as PostResource;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    // TODO check codes. make trait response?
    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\Api\IndexPostRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexPostRequest $request)
    {
        $limit = $request->get('limit', (new User())->getPerPage());
        $posts = Post::with(['user'])->paginate($limit);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\StorePostRequest  $request
     * @return \App\Http\Resources\Post
     */
    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->text = $request->text;
        $post->user()->associate($request->user());
        $post->save();

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \App\Http\Resources\Post
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments']);
        $post->comments->load(['user']);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\UpdatePostRequest  $request
     * @param  \App\Post  $post
     * @return \App\Http\Resources\Post
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->title = $request->get('title', $post->title);
        $post->text = $request->get('text', $post->text);
        $post->save();

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response(null, 204);
    }
}
