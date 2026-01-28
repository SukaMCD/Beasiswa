<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('external_id')
                    ->label('ID Pesanan')
                    ->disabled(),
                Forms\Components\Select::make('id_user')
                    ->relationship('user', 'nama_user')
                    ->label('Customer')
                    ->disabled(),
                Forms\Components\TextInput::make('total_amount')
                    ->label('Total Pembayaran')
                    ->prefix('Rp')
                    ->numeric()
                    ->disabled(),
                Forms\Components\Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'PENDING' => 'Pending',
                        'PAID' => 'Paid',
                        'EXPIRED' => 'Expired',
                        'CANCELLED' => 'Cancelled',
                    ])
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('shipping_status')
                    ->label('Status Pengiriman')
                    ->options([
                        'PENDING' => 'Pending',
                        'PROCESSING' => 'Diproses',
                        'SHIPPED' => 'Dikirim',
                        'DELIVERED' => 'Sampai',
                        'CANCELLED' => 'Dibatalkan',
                    ])
                    ->native(false)
                    ->required(),
                Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('nama_produk')->label('Produk')->disabled(),
                        Forms\Components\TextInput::make('jumlah')->numeric()->disabled(),
                        Forms\Components\TextInput::make('harga_satuan')->prefix('Rp')->numeric()->disabled(),
                        Forms\Components\TextInput::make('subtotal')->prefix('Rp')->numeric()->disabled(),
                    ])
                    ->columnSpanFull()
                    ->addable(false)
                    ->deletable(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('external_id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.nama_user')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipping_address')
                    ->label('Alamat')
                    ->limit(30)
                    ->tooltip(fn(Order $record): string => $record->shipping_address ?? ''),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'PENDING' => 'warning',
                        'PAID' => 'success',
                        'EXPIRED', 'CANCELLED' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('shipping_status')
                    ->label('Pengiriman')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'PENDING' => 'gray',
                        'PROCESSING' => 'info',
                        'SHIPPED' => 'warning',
                        'DELIVERED' => 'success',
                        'CANCELLED' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Order')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'PENDING' => 'Pending',
                        'PAID' => 'Paid',
                        'EXPIRED' => 'Expired',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
    public static function getNavigationGroup(): string
    {
        return 'Shop';
    }
}
