<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orderdetail;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\EditOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Orderdetails  $orderdetails
     * @return \Illuminate\Http\Response
     */
    public function show(Orderdetails $orderdetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orderdetails  $orderdetails
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $order->load(['orderDetails' => function ($query) {
            $query->where('del_flg', 0); // orderDetails 内で del_flg = 0 のみを取得
        }, 'orderDetails.product']);

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orderdetails  $orderdetails
     * @return \Illuminate\Http\Response
     */
    public function update(EditOrderRequest $request, Order $order)
    {
        foreach ($order->orderDetails as $orderDetail) {
            $product = $orderDetail->product;
            $quantity = $request->quantities[$orderDetail->id] ?? 0; // quantities配列から数量を取得

            // 在庫が足りない場合、エラーメッセージを設定
            if ($quantity > $product->lot) {
                return redirect()->back()->withErrors([
                    'quantities.' . $orderDetail->id => "在庫が不足しています。最大注文可能数は {$product->lot} です。"
                ]);
            }

            // 在庫の調整
            $quantityDifference = $quantity - $orderDetail->quantity;
            $product->lot -= $quantityDifference;
            $product->save();

            // 注文詳細の更新
            $orderDetail->quantity = $quantity;
            $orderDetail->price = $product->price * $quantity;
            $orderDetail->save();
        }

        // 注文の合計金額を再計算して更新
        $order->total_price = $order->orderDetails->sum('price');
        $order->save();

        return redirect()->route('orders.myindex');
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orderdetails  $orderdetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function myindex()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', auth()->id())
        ->where('del_flg', 0)
        ->with(['orderDetails' => function ($query) {
            $query->where('del_flg', 0); // リレーション内で条件を指定
        }, 'orderDetails.product'])
        ->get();
        return view('orders.myindex', compact('orders'));
    }
}


