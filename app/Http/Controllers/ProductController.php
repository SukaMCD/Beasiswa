<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categories;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search Filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // Category Filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('id_kategori', $request->category);
        }

        $products = $query->orderByDesc('created_at')->paginate(12)->withQueryString();
        $categories = Categories::all();

        return view('products', compact('products', 'categories'));
    }
}
