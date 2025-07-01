<?php

namespace App\Filament\Resources\NewsletterFollowerResource\Pages;

use App\Filament\Resources\NewsletterFollowerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsletterFollowers extends ListRecords
{
    protected static string $resource = NewsletterFollowerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
