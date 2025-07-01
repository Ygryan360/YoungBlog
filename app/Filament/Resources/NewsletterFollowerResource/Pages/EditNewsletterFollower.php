<?php

namespace App\Filament\Resources\NewsletterFollowerResource\Pages;

use App\Filament\Resources\NewsletterFollowerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterFollower extends EditRecord
{
    protected static string $resource = NewsletterFollowerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
