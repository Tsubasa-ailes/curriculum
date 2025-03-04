<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'del_flg',
    ];

    // コメントのユーザーを取得
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // コメントの商品を取得
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
