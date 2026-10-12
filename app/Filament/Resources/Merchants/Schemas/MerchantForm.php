<?php

namespace App\Filament\Resources\Merchants\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MerchantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('shop_name')
                    ->required(),
                TextInput::make('contact')
                    ->required(),
                Select::make('status')
                    ->options(['approve' => 'Approve', 'reject' => 'Reject', 'pending' => 'Pending'])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
