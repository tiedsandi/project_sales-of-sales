<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{

    public function create()
    {
        $products = Product::where('is_active', 1)->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => (int)$product->product_price,
                'image' => $product->product_photo,
                'option' => '',
            ];
        });
        return view('pos-sale', compact('products'));
    }


    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'cart' => 'required',
            'cash' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'change' => 'required|numeric|min:0',
        ]);

        $data = json_decode($request->cart, true);


        $latestIdOrder = Order::max('id') + 1;
        $order = Order::create([
            'order_code' => $this->generateOrderCode($latestIdOrder),
            'order_date' => now(),
            'order_amount' => $request->total,
            'order_change' =>  $request->change,
            'order_status' =>  1,
            'customer_name' => "John Doe",
        ]);

        foreach ($data as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['productId'],
                'qty' => $item['qty'],
                'order_price' => $item['price'],
                'order_subtotal' => $item['qty'] * $item['price'],
            ]);
        }
        // return $request;

        Alert::success('Success', 'Transaction has been successfully processed.');
        return redirect('/pos-sale');
    }

    private function generateOrderCode($orderId)
    {
        $prefix = 'POS';
        $date = now()->format('Ymd');

        return "{$prefix}-{$date}-" . str_pad($orderId, 6, '0', STR_PAD_LEFT);
    }


    // pos page
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->paginate(5);
        return view('pos.index', compact('orders'));
    }

    public function show(string $id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id);
        // return $order;
        return view('pos.show', compact('order'));
    }

    public function print(string $id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id);
        // return $order;
        return view('print', compact('order'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'cash_received' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($id);

        if ($request->cash_received < $order->order_amount) {
            Alert::error('Error', 'Insufficient payment amount.');
            return back();
        }

        $order->update([
            'order_change' => $request->cash_received - $order->order_amount,
            'order_status' => 1, // Mark as paid
        ]);

        Alert::success('Success', 'Payment has been successfully processed.');
        return redirect()->route('pos.index');
    }
}
