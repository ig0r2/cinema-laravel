<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * fields that are mass assignable
     */
    protected $fillable = ['user_id', 'subject', 'content', 'reply', 'reply_by'];
    /**
     * Get the user that owns the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that replied to the message.
     */
    public function replyBy()
    {
        return $this->belongsTo(User::class, 'reply_by');
    }
}
