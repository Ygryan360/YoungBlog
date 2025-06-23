<?php

namespace App\Models;

use Database\Factories\NewsletterFollowerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterFollower extends Model
{
    /** @use HasFactory<NewsletterFollowerFactory> */
    use HasFactory;

    protected $fillable = ['email', 'verified', 'is_register', 'token'];
}
