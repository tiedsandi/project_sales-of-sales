<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function actionLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials)) {
            Alert::success('Welcome back', 'Success Login');

            if (auth()->user()->role_id == 3) {
                return redirect('kasir');
            }
            return redirect('/');
        } else {
            Alert::toast('Email and Password are wrong', 'error');
            return back()->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        Alert::toast('Success Logout!', 'success');
        return redirect()->to('/');
    }

    public function dashboard()
    {
        $today = Carbon::today();
        $SalesToday = Order::whereDate('order_date', $today)->count();
        $AmountToday = Order::whereDate('order_date', $today)->sum('order_amount');
        $LastOrders = Order::whereDate('order_date', $today)
            ->orderBy('order_date', 'desc')
            ->limit(5)
            ->get();
        $LowStock = Product::active()->notDelete()->orderBy('product_qty', 'asc')
            ->limit(5)
            ->get();

        $TopProducts = OrderDetail::topProducts();


        return view('dashboard.dashboard', compact('SalesToday', 'AmountToday', 'LastOrders', 'LowStock', 'TopProducts'));
    }
}
