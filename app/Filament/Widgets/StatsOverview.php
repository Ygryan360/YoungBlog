<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\NewsletterFollower;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $posts = Post::query()->count();
        $users = User::query()->count();
        $comments = Comment::query()->count();
        $subscribers = NewsletterFollower::query()->count();

        return [
            Stat::make('Articles', (string) $posts),
            Stat::make('Utilisateurs', (string) $users),
            Stat::make('Commentaires', (string) $comments),
            Stat::make('Abonnés', (string) $subscribers),
        ];
    }
}
