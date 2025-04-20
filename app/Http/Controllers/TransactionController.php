<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{

    public function create()
    {
        $categories = Category::all();
        $products = Product::all();

        return view('pos-sale', compact('categories', 'products'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'cart_data' => 'required',
            'cash_received' => 'nullable|numeric|min:0',
            'change' => 'nullable|numeric|min:0'
        ]);

        $data = json_decode($request->cart_data, true);

        if (!$data || empty($data['orders'])) {
            Alert::error('Error', 'Cart is empty.');
            return back();
        }

        $latestIdOrder = Order::max('id') + 1;
        $order = Order::create([
            'order_code' => $this->generateOrderCode($latestIdOrder),
            'order_date' => now(),
            'order_amount' => $data['total'],
            'order_change' => $request->change ?? 0,
            'order_status' => $request->change ? 1 : 0
        ]);

        foreach ($data['orders'] as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['productId'],
                'qty' => $item['quantity'],
                'order_price' => $item['price'],
                'order_subtotal' => $item['total'],
            ]);
        }

        Alert::success('Success', 'Transaction has been successfully processed.');
        return redirect('/pos-sale');
    }

    private function generateOrderCode($orderId)
    {
        $prefix = 'POS';
        $date = now()->format('Ymd');

        return "{$prefix}-{$date}-" . str_pad($orderId, 6, '0', STR_PAD_LEFT);
    }
}
