<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(Orderdetail::class, 'order_id');
    }

    public function getFilteredTotalPriceAttribute()
    {
        return $this->orderDetails->sum(function ($detail) {
            $unitPrice = $detail->product->price;  // 例えば、Orderdetailに関連するProductの単価を使用
            return $detail->price * $detail->quantity;
        });
    }
}
