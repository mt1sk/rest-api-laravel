<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Post;

class PostsTableSeeder extends Seeder
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
        if (!empty($users_ids)) {
            factory(Post::class, 10)->make()->each(function($post) use ($users_ids) {
                $post->user_id = $users_ids[array_rand($users_ids)];
                $post->save();
            });
        }
    }
}
