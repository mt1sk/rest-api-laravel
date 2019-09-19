<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\IndexPostRequest;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;
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
     * @return \Illuminate\Http\Response
     */
    public function index(IndexPostRequest $request)
    {
        $limit = $request->get('limit', (new User())->getPerPage());
        $posts = Post::paginate($limit);
        $posts->load(['user']);

        // TODO resource
        $result = [
            'current_page' => $posts->currentPage(),
            'per_page' => $posts->perPage(),
            'last_page' => $posts->lastPage(),
            'posts_count' => $posts->total(),
            'is_last_page' => !$posts->hasMorePages(),
            'posts' => $posts->all(),
        ];
        return response()->json(['success'=>true, 'data'=>$result]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->text = $request->text;
        $post->user_id = $request->user()->id;
        $post->save();

        return response()->json(['success'=>true, 'data'=>$post], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments']);
        $post->comments->load(['user']);
        return response()->json(['success'=>true, 'data'=>$post], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\UpdatePostRequest  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->title = $request->title;
        $post->text = $request->text;
        $post->save();

        return response()->json(['success'=>true, 'data'=>$post], 200);
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
        return response()->json(['success'=>true]);
    }
}
