<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;
    protected static ?string $navigationGroup = 'Communauté';
    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nom')
                    ->disabled(),
                Forms\Components\TextInput::make('email')
                    ->disabled(),
                Forms\Components\Textarea::make('content')
                    ->label('Message')
                    ->columnSpanFull()
                    ->rows(8)
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->limit(15)
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Message')
                    ->limit(30)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('read')
                    ->label('Lu')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reader.name')
                    ->label('Lu par')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('unread')
                    ->label('Non lus')
                    ->query(fn($query) => $query->where('read', false)),
            ])
            ->actions([
                Action::make('markAsRead')
                    ->label('Lire')
                    ->icon('heroicon-o-check')
                    ->action(fn(Message $record) => $record->markAsRead())
                    ->requiresConfirmation()
                    ->visible(fn(Message $record) => !$record->read),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessages::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
