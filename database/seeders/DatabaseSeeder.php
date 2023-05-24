<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Genre;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Schema::disableForeignKeyConstraints();
        Movie::truncate();
        Genre::truncate();
        Actor::truncate();
        Director::truncate();
        Schema::enableForeignKeyConstraints();
        
        Genre::create([
            'name' => 'Action',
        ]);
        Genre::create([
            'name' => 'Adventure',
        ]);
        Genre::create([
            'name' => 'Sci-Fi',
        ]);
        Genre::create([
            'name' => 'Comedy',
        ]);
        Genre::create([
            'name' => 'Drama',
        ]);
        Genre::create([
            'name' => 'Fantasy',
        ]);
        Genre::create([
            'name' => 'Horror',
        ]);
        Genre::create([
            'name' => 'Mystery',
        ]);

        Actor::create([
            'name' => 'Test Actor',
        ]);
        Actor::create([
            'name' => 'Test Actor 2',
        ]);
        Actor::create([
            'name' => 'Test Actor 3',
        ]);

        Director::create([
            'name' => 'Test Director',
        ]);
        Director::create([
            'name' => 'Test Director 2',
        ]);
        Director::create([
            'name' => 'Test Director 3',
        ]);

        Movie::create([
            'title' => 'Star Wars I',
            'image_url' => 'https://via.placeholder.com/150',
            'runtime' => 120,
            'release_date' => '2021-05-20',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);
        Movie::create([
            'title' => 'Star Wars II',
            'image_url' => 'https://via.placeholder.com/150',
            'runtime' => 120,
            'release_date' => '2021-05-20',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);
        Movie::create([
            'title' => 'Star Wars III',
            'image_url' => 'https://via.placeholder.com/150',
            'runtime' => 120,
            'release_date' => '2021-05-20',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $movie = Movie::find(1);
        $movie->genres()->attach([1, 3, 5]);
        $movie->actors()->attach([1, 2, 3]);
        $movie->directors()->attach([1, 2, 3]);

        $movie = Movie::find(2);
        $movie->genres()->attach([1, 2, 3]);
        $movie->actors()->attach([1, 2, 3]);
        $movie->directors()->attach([1, 2, 3]);

        $movie = Movie::find(3);
        $movie->genres()->attach([1, 3, 5]);
        $movie->actors()->attach([1, 2, 3]);
        $movie->directors()->attach([1, 2, 3]);
    }
}
