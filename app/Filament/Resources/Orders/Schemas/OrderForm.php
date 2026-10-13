<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('merchant_id')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed'])
                    ->default('pending')
                    ->required(),
                Select::make('payment_status')
                    ->options(['paid' => 'Paid', 'unpaid' => 'Unpaid'])
                    ->default('unpaid')
                    ->required(),
                Select::make('payment_method')
                    ->options(['cod' => 'Cod', 'khalti' => 'Khalti'])
                    ->default('cod')
                    ->required(),
                TextInput::make('khalti_pidx')
                    ->default(null),
                TextInput::make('khalti_transaction_id')
                    ->default(null),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                TextInput::make('contact_no')
                    ->required(),
                Textarea::make('address')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
