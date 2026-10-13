<?php

namespace App\Filament\Widgets;

use App\Models\Merchant;
use App\Models\Order;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $orders = route('filament.admin.resources.orders.index');

        return [
            Stat::make('Total Merchants', Merchant::where('status', 'approve')->count())
                ->icon(Heroicon::OutlinedBuildingStorefront)
                ->color('success')
                ->url(route('filament.admin.resources.merchants.index')),

            Stat::make('Total Orders', Order::count())
                ->icon(Heroicon::OutlinedShoppingCart)
                ->color('info')
                ->url($orders),

            Stat::make('Pending Orders', Order::where('status', 'pending')->count())
                ->icon(Heroicon::OutlinedClock)
                ->color('warning')
                ->url(route('filament.admin.resources.orders.index', [
                    'filters' => ['status' => ['value' => 'pending']],
                ])),
        ];
    }
}
