<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $paidOrders = Order::where('payment_status', 'PAID')->get();
        $totalGross = $paidOrders->sum('total_amount');
        $transactionCount = $paidOrders->count();

        // Calculation Assumptions
        // Total = Subtotal + PPN (11%) -> Subtotal = Total / 1.11
        $subtotal = $totalGross / 1.11;
        $ppn = $totalGross - $subtotal;

        // Est. Xendit Fee (Average ~4500 for VA/E-Wallet)
        // If admin_fee is stored (from Webhook), use it. otherwise estimate
        $realFees = $paidOrders->sum('admin_fee');
        $estFees = $paidOrders->whereNull('admin_fee')->count() * 4500;
        $totalFees = $realFees + $estFees;

        // Net Profit = Subtotal - Operation Costs (Fees)
        $netProfit = $subtotal - $totalFees;

        return [
            Stat::make('Total Pendapatan (Kotor)', 'Rp ' . number_format($totalGross, 0, ',', '.'))
                ->description('Total masuk (Termasuk PPN)')
                ->color('primary'),

            Stat::make('Estimasi Keuntungan Bersih', 'Rp ' . number_format($netProfit, 0, ',', '.'))
                ->description('Total - PPN - Biaya Admin')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Total Potongan', 'Rp ' . number_format($ppn + $totalFees, 0, ',', '.'))
                ->description('PPN (11%) + Fee Xendit')
                ->descriptionIcon('heroicon-m-scissors')
                ->color('danger'),

            Stat::make('Total Penjualan', Order::count())
                ->description('Semua pesanan masuk')
                ->color('info'),
        ];
    }
}
