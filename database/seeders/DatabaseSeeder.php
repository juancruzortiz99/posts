<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tags;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Storage::deleteDirectory('public/posts');
        Storage::makeDirectory('public/posts');

        $this->call(UserSeeder::class);
        Category::factory(4)->create();
        Tags::factory(8)->create();
        $this->call(PostSeeder::class);
    }
}
