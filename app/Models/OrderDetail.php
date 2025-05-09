<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'order_price',
        'order_subtotal',
    ];

    protected $appends = ['formatted_price', 'formatted_subtotal'];

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp. ' . number_format($this->order_price, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp. ' . number_format($this->order_subtotal, 0, ',', '.');
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function topProducts($limit = 3)
    {
        return self::select('product_id')
            ->selectRaw('SUM(qty) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product') // supaya sekalian load data produk
            ->limit($limit)
            ->get();
    }
}
