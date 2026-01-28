<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

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
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalGross, 0, ',', '.'))
                ->description('Total dari semua pesanan Lunas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Total Pesanan', Order::count())
                ->description('Semua pesanan yang masuk')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),

            Stat::make('Total Produk', \App\Models\Product::count())
                ->description('Produk aktif yang tersedia')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('primary'),

            Stat::make('Total Customer', \App\Models\User::count())
                ->description('User yang terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
