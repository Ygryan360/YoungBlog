<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\EmailVerificationCode;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Mail;
use App\Enums\UserRole;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'verification_code',
        'avatar_url',
        'username',
        'password',
        'email_verified_at'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdminOrAuthor() || $this->isSuperAdmin();
    }

    public function isAdminOrAuthor(): bool
    {
        return $this->role === UserRole::Admin || $this->role === UserRole::Author;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === UserRole::Superadmin;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::disk('public')->url($this->avatar_url) : null;
    }

    public function getCategoriesCountAttribute(): int
    {
        return $this->categories()->count();
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function getPostsCountAttribute(): int
    {
        return $this->posts()->count();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getCommentsCountAttribute(): int
    {
        return $this->comments()->count();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isAuthor(): bool
    {
        return $this->role === UserRole::Author;
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class,
    ];

    public function sendEmailVerificationCode()
    {
        $verificationCode = rand(100000, 999999);
        $this->verification_code = $verificationCode;
        $this->save();
        Mail::to($this->email)->send(new EmailVerificationCode($this));
    }
}
