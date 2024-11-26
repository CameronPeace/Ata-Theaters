<?php

namespace Database\Seeders;

use App\Models\Repositories\MovieRepository;
use App\Models\Repositories\TheaterRepository;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new TheaterRepository)->createTheaters(15);
        (new MovieRepository)->createMovies(10);


        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
