<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $selectedRole = session('selected_role');

        if ($selectedRole == 'Kasir' || $selectedRole == 'Pimpinan') {
            $products = Product::where('is_active', 1)
                ->orderBy('product_qty', 'asc')
                ->paginate(10);
            return view('dashboard.stock_barang', compact('products'));
        } elseif ($selectedRole == 'Administrator') {
            $popularProducts = DB::table('products as a')
                ->leftJoin(DB::raw('(SELECT COUNT(id) as total_order, SUM(qty) as total_qty, SUM(order_subtotal) as subtotal, product_id FROM order_details GROUP BY product_id) as b'), 'b.product_id', '=', 'a.id')
                ->select('a.id', 'a.product_name', 'a.product_photo', 'b.total_order', 'b.total_qty', 'b.subtotal')
                ->orderByDesc('b.total_qty')
                ->limit(10)
                ->get();

            return view('dashboard.sering_muncul', compact('popularProducts'));
        }
    }
}
