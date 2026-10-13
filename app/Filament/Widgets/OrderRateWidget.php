<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class OrderRateWidget extends ChartWidget
{
    protected ?string $heading = 'Orders per month';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    // Year dropdown: from the first order's year up to the current year
    protected function getFilters(): ?array
    {
        $first = Order::min('created_at');
        $start = $first ? Carbon::parse($first)->year : now()->year;

        return collect(range(now()->year, $start))
            ->mapWithKeys(fn($y) => [(string) $y => (string) $y])
            ->all();
    }

    protected function getData(): array
    {
        $year = (int) ($this->filter ?: now()->year);

        // Grouped in PHP so it works on SQLite, MySQL and PostgreSQL alike
        $counts = Order::whereYear('created_at', $year)
            ->pluck('created_at')
            ->countBy(fn($date) => Carbon::parse($date)->month);

        return [
            'datasets' => [
                [
                    'label' => "Orders in {$year}",
                    'data' => collect(range(1, 12))
                        ->map(fn($month) => $counts->get($month, 0))
                        ->all(),
                    'borderColor' => '#f85f11',
                    'backgroundColor' => 'rgba(248, 95, 17, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    // Whole numbers only on the Y axis, since you can't have half an order
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => ['precision' => 0],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
