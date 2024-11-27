<?php

namespace Database\Seeders;

use App\Models\Repositories\MovieRepository;
use App\Models\Repositories\TheaterRepository;
use App\Models\Sale;
use App\Models\Screening;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new TheaterRepository)->createTheaters(15);
        (new MovieRepository)->createMovies(45);
        Screening::factory(300)->create();
        Sale::factory(2500)->create();
    }
}
