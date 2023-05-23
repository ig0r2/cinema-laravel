<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['movie_id', 'hall_id', 'time', 'price', 'type'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'time' => 'datetime',
    ];

    /**
     * Get the movie that owns the screening.
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Get the hall that owns the screening.
     */
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
}
