<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Message;
use App\Models\NewsletterFollower;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $superadmin = User::factory()->create([
            'name' => 'Rayane Tchabodi',
            'email' => 'ygr@youngblog.tech',
            'role' => 'superadmin'
        ]);

        User::factory(30)->create();

        Category::factory(20)->create([
            'author_id' => $superadmin->id
        ]);
        Tag::factory(40)->create([
            'author_id' => $superadmin->id
        ]);
        Post::factory(100)->create([
            'author_id' => $superadmin->id,
        ]);
        Comment::factory(70)->create();
        NewsletterFollower::factory(100)->create();
        Message::factory(30)->create();
    }
}
