<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'capacity'];

    /**
     * Get the screenings for the hall.
     */
    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }
}
