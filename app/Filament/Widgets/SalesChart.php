<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Tren Penjualan (30 Hari Terakhir)';
    protected static string $color = 'success';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'md';

    protected function getData(): array
    {
        // If Flowframe/Trend is not installed, we use a simple eloquent query
        // Usually, users might not have it installed, so let's check or use raw

        $data = Order::where('payment_status', 'PAID')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $data->map(fn($value) => $value->total)->toArray(),
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->map(fn($value) => Carbon::parse($value->date)->format('d M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
