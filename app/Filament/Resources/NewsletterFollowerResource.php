<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterFollowerResource\Pages;
use App\Models\NewsletterFollower;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsletterFollowerResource extends Resource
{
    protected static ?string $model = NewsletterFollower::class;
    protected static ?string $navigationGroup = 'Communauté';
    protected static ?string $navigationLabel = 'Abonnés';
    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('token')
                    ->required()
                    ->label('Token')
                    ->maxLength(255),
                Forms\Components\Toggle::make('verified')
                    ->required()
                    ->label('Email Confirmé'),
                Forms\Components\Toggle::make('is_register')
                    ->required()
                    ->label('Inscrit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('token')
                    ->label('Token')
                    ->limit(20)
                    ->copyable(),
                Tables\Columns\IconColumn::make('verified')
                    ->label('Confirmé')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_register')
                    ->label('Inscrit')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ajouté le')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->disabled(fn($record) => $record->is_register),
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
            'index' => Pages\ListNewsletterFollowers::route('/'),
            'create' => Pages\CreateNewsletterFollower::route('/create'),
            'edit' => Pages\EditNewsletterFollower::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
