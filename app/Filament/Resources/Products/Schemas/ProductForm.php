<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;

class ProductForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->components([
                TextInput::make('nama_produk')
                    ->required(),
                Select::make('id_kategori')
                    ->relationship('category', 'nama_kategori')
                    ->required(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
                TextInput::make('harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('stok')
                    ->required()
                    ->numeric(),
                FileUpload::make('gambar')
                    ->image()
                    ->directory('product-images')
                    ->storeFileNamesIn('gambar_nama_file'),
            ]);
    }
}
