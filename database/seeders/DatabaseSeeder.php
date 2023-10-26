<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Tweet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            "name"=>fake()->name(),
            "userName"=>"Ner0",
            "email"=>fake()->email(),
            "password" => bcrypt("password"),
        ]);

        Tweet::factory(30)->create([
            "user_id" => $user->id
        ]);
    }
}
