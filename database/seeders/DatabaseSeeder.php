<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Genre;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Hall;
use App\Models\Message;
use App\Models\Movie;
use App\Models\Review;
use App\Models\Screening;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Ticket::truncate();
        Screening::truncate();
        Review::truncate();
        Movie::truncate();
        Genre::truncate();
        Actor::truncate();
        Director::truncate();
        Hall::truncate();
        User::truncate();
        Message::truncate();
        DB::table('movie_actor')->truncate();
        DB::table('movie_director')->truncate();
        DB::table('movie_genre')->truncate();
        Schema::enableForeignKeyConstraints();

        User::factory()
            ->admin()
            ->create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
            ]);
        User::factory()
            ->manager()
            ->create([
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
            ]);
        $users = User::factory(10)->create();

        Hall::create(['name' => 'Sala 1', 'capacity' => 50]);
        Hall::create(['name' => 'Sala 2', 'capacity' => 25]);
        Hall::create(['name' => 'Sala 3', 'capacity' => 40]);
        Hall::create(['name' => 'Sala 4', 'capacity' => 30]);
        $halls = Hall::all();

        $movie = Movie::create([
            'title' => 'Star Wars: Episode I - The Phantom Menace',
            'image_url' => 'movies/dQaWNVW63A2XdqTIcftN729Xefog4zaJYaW1Er9F.jpg',
            'runtime' => 136,
            'release_date' => '1999-05-19',
            'description' =>
                'Jedi Knights Qui-Gon Jinn and Obi-Wan Kenobi set out to stop the Trade Federation from invading Naboo. While travelling, they come across a gifted boy, Anakin, and learn that the Sith have returned.',
        ]);
        $movie
            ->genres()
            ->attach([
                Genre::firstOrCreate(['name' => 'Action'])->id,
                Genre::firstOrCreate(['name' => 'Adventure'])->id,
                Genre::firstOrCreate(['name' => 'Fantasy'])->id,
                Genre::firstOrCreate(['name' => 'Sci-Fi'])->id,
            ]);
        $movie
            ->actors()
            ->attach([
                Actor::firstOrCreate(['name' => 'Ewan McGregor'])->id,
                Actor::firstOrCreate(['name' => 'Liam Neeson'])->id,
                Actor::firstOrCreate(['name' => 'Natalie Portman'])->id,
            ]);
        $movie->directors()->attach([Director::firstOrCreate(['name' => 'George Lucas'])->id]);

        $movie = Movie::create([
            'title' => 'Star Wars: Episode II - Attack of the Clones',
            'image_url' => 'movies/nkYOFZrA7COJuDNvHqR5oqURTD6kDnlf57PwUCmq.jpg',
            'runtime' => 142,
            'release_date' => '2002-05-16',
            'description' =>
                'While pursuing an assassin, Obi Wan uncovers a sinister plot to destroy the Republic. With the fate of the galaxy hanging in the balance, the Jedi must defend the galaxy against the evil Sith.',
        ]);
        $movie
            ->genres()
            ->attach([
                Genre::firstOrCreate(['name' => 'Action'])->id,
                Genre::firstOrCreate(['name' => 'Adventure'])->id,
                Genre::firstOrCreate(['name' => 'Fantasy'])->id,
                Genre::firstOrCreate(['name' => 'Sci-Fi'])->id,
            ]);
        $movie
            ->actors()
            ->attach([
                Actor::firstOrCreate(['name' => 'Ewan McGregor'])->id,
                Actor::firstOrCreate(['name' => 'Natalie Portman'])->id,
                Actor::firstOrCreate(['name' => 'Hayden Christensen'])->id,
            ]);
        $movie->directors()->attach([Director::firstOrCreate(['name' => 'George Lucas'])->id]);

        $movie = Movie::create([
            'title' => 'Star Wars: Episode III – Revenge of the Sith',
            'image_url' => 'movies/2wNaiHGJNnq3J1uZWCgBYncQGvwhxrmM0AmN2XLu.jpg',
            'runtime' => 140,
            'release_date' => '2005-05-19',
            'description' =>
                'Anakin joins forces with Obi-Wan and sets Palpatine free from the evil clutches of Count Doku. However, he falls prey to Palpatine and the Jedis\' mind games and gives into temptation.',
        ]);
        $movie
            ->genres()
            ->attach([
                Genre::firstOrCreate(['name' => 'Action'])->id,
                Genre::firstOrCreate(['name' => 'Adventure'])->id,
                Genre::firstOrCreate(['name' => 'Fantasy'])->id,
                Genre::firstOrCreate(['name' => 'Sci-Fi'])->id,
            ]);
        $movie
            ->actors()
            ->attach([
                Actor::firstOrCreate(['name' => 'Ewan McGregor'])->id,
                Actor::firstOrCreate(['name' => 'Natalie Portman'])->id,
                Actor::firstOrCreate(['name' => 'Hayden Christensen'])->id,
            ]);
        $movie->directors()->attach([Director::firstOrCreate(['name' => 'George Lucas'])->id]);

        $movies = Movie::all();
        $movies->each(function ($movie) use ($halls, $users) {
            for ($i = 0; $i < 30; $i++) {
                $hall = $halls->random();
                $screening = Screening::create([
                    'time' => fake()->dateTimeBetween('-2 days', '+5 days'),
                    'price' => fake()->numberBetween(300, 600),
                    'type' => fake()->randomElement(['2D', '3D', '4DX', 'IMAX', '5D']),
                    'seats_available' => $hall->capacity,
                    'hall_id' => $hall->id,
                    'movie_id' => $movie->id,
                ]);
                for ($j = 0; $j < $hall->capacity / 5; $j++) {
                    Ticket::create([
                        'screening_id' => $screening->id,
                        'seat' => $j + 1,
                        'price' => $screening->price,
                        'user_id' => $users->random()->id,
                    ]);
                    $screening->seats_available--;
                }
                $screening->save();
            }
            $users->each(function ($user) use ($movie) {
                if (fake()->boolean(50)) {
                    Review::create([
                        'rating' => fake()->numberBetween(1, 10),
                        'content' => fake()->paragraph(3),
                        'user_id' => $user->id,
                        'movie_id' => $movie->id,
                    ]);
                }
            });
        });
    }
}
