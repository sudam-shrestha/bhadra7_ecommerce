<?php

namespace App\Filament\Merchant\Resources\Products\Schemas;

use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Product Information')
                    ->description('Basic details customers will see.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state, string $operation) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Product Image')
                    ->collapsible()
                    ->schema([
                        FileUpload::make('img')
                            ->label('Main image')
                            ->image()
                            ->imageEditor()
                            ->directory('products')
                            ->maxSize(2048)
                            ->required(),
                    ]),

                Section::make('Variants')
                    ->description('Add each size, color or option with its own price.')
                    ->schema([
                        Repeater::make('product_variants')
                            ->label('Variants')
                            ->relationship('product_variants')
                            ->minItems(1)
                            ->addActionLabel('Add variant')
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                            ->columns(3)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('Rs.'),

                                TextInput::make('discount')
                                    ->numeric()
                                    ->minValue(0)
                                    ->lte('price')
                                    ->default(0)
                                    ->prefix('Rs.'),

                                FileUpload::make('img')
                                    ->label('Variant image')
                                    ->image()
                                    ->directory('products/variants')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
