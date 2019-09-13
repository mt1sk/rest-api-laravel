<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\User;
use App\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users_ids = User::all('id')->modelKeys();
        if (empty($users_ids)) {
            $this->call(UsersTableSeeder::class);
            $users_ids = User::all('id')->modelKeys();
        }
        $posts_ids = Post::all('id')->modelKeys();
        if (empty($posts_ids)) {
            $this->call(PostsTableSeeder::class);
            $posts_ids = Post::all('id')->modelKeys();
        }

        if (!empty($users_ids) && !empty($posts_ids)) {
            factory(Comment::class, 30)->make()->each(function($comment) use ($users_ids, $posts_ids) {
                $comment->post_id = $posts_ids[array_rand($posts_ids)];
                $comment->user_id = $users_ids[array_rand($users_ids)];
                $comment->save();
            });
        }
    }
}
