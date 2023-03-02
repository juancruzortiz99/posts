<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name'=>'Juan Cruz Ortiz', 'email' => 'juancruzortiz@gmail.com', 'password' => bcrypt('juanjuan')]);
        User::factory(9)->create();
    }
}
