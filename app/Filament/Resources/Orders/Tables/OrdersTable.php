<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->with(['user', 'merchant']))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('Order')
                    ->formatStateUsing(fn($state) => 'ORD-' . str_pad($state, 5, '0', STR_PAD_LEFT))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->description(fn($record) => $record->user?->email)
                    ->searchable(),

                TextColumn::make('merchant.shop_name')
                    ->label('Shop')
                    ->searchable(),

                SelectColumn::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'processing' => 'Processing',
                        'completed'  => 'Completed',
                    ])
                    ->selectablePlaceholder(false)
                    ->afterStateUpdated(fn() => Notification::make()
                        ->title('Order status updated')
                        ->success()
                        ->send()),

                SelectColumn::make('payment_status')
                    ->label('Payment')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'paid'   => 'Paid',
                    ])
                    ->selectablePlaceholder(false)
                    ->afterStateUpdated(fn() => Notification::make()
                        ->title('Payment status updated')
                        ->success()
                        ->send()),

                TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state === 'khalti' ? 'Khalti' : 'Cash on delivery')
                    ->color(fn($state) => $state === 'khalti' ? 'info' : 'gray'),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('NPR')
                    ->sortable(),

                TextColumn::make('contact_no')
                    ->label('Contact')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('khalti_pidx')
                    ->label('Khalti pidx')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('khalti_transaction_id')
                    ->label('Khalti transaction')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Placed on')
                    ->dateTime('d M Y, h:i A')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'processing' => 'Processing',
                        'completed'  => 'Completed',
                    ]),
                SelectFilter::make('payment_status')
                    ->label('Payment')
                    ->options(['unpaid' => 'Unpaid', 'paid' => 'Paid']),
                SelectFilter::make('payment_method')
                    ->label('Method')
                    ->options(['cod' => 'Cash on delivery', 'khalti' => 'Khalti']),
                SelectFilter::make('merchant_id')
                    ->label('Shop')
                    ->relationship('merchant', 'shop_name'),
            ])
            ->recordActions([
                Action::make('receipt')
                    ->label('Details')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->color('info')
                    ->url(fn($record) => route('admin.orders.receipt', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
