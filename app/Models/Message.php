<?php

namespace App\Models;

use Database\Factories\MessageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    /** @use HasFactory<MessageFactory> */
    use HasFactory;

    protected $fillable = ['name', 'email', 'content', 'read', 'reader_id'];

    public function reader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reader_id');
    }
}
