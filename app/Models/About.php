<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Parsedown;

class About extends Model
{
    protected $table = 'about';
    protected $fillable = [
        'content',
        'image',
        'views',
    ];

    public function getImageUrl(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    public function parsedContent(): string
    {
        $parsedown = new Parsedown();
        $parsedown->setSafeMode(true);
        $parsedown->setBreaksEnabled(true);

        return $parsedown->text($this->content);
    }
}
