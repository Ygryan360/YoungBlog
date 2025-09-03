<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Communauté';
    protected static ?string $navigationLabel = 'Utilisateurs';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->disabled(),
                Forms\Components\TextInput::make('email')
                    ->disabled(),
                Forms\Components\FileUpload::make('avatar_url')
                    ->image()
                    ->disabled()
                    ->label('Avatar'),
                Forms\Components\Select::make('role')
                    ->options(fn() => collect(\App\Enums\UserRole::cases())->mapWithKeys(fn($c) => [$c->value => $c->label()])->toArray())
                    ->native(false)
                    ->disabled(fn($record) => $record->role === \App\Enums\UserRole::Superadmin)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        \App\Enums\UserRole::User->value => 'gray',
                        \App\Enums\UserRole::Author->value => 'info',
                        \App\Enums\UserRole::Admin->value => 'warning',
                        \App\Enums\UserRole::Superadmin->value => 'danger',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
