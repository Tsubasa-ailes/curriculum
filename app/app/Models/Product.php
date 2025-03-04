<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }
    public function decreaseStock($quantity)
    {
        if ($this->lot >= $quantity) {
            $this->lot -= $quantity;
            $this->save();
            return true;
        }
        return false; // 在庫が不足している場合
    }
}
