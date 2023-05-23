<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'image_url', 'runtime', 'release_date', 'description'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'release_date' => 'datetime:Y-m-d',
    ];

    /**
     * Get the genres for the movie.
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    /**
     * Get the actors for the movie.
     */
    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'movie_actor');
    }

    /**
     * Get the directors for the movie.
     */
    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(Director::class, 'movie_director');
    }

    /**
     * Get the screenings for the movie.
     */
    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }

    /**
     * Get screenings grouped by date.
     */
    public function screeningsByDate()
    {
        return $this->screenings()
            ->get()
            ->groupBy(function ($item) {
                return $item->time->format('Y-m-d');
            })
            ->sortKeys();
    }
}
