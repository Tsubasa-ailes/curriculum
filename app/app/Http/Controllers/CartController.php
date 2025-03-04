<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $carts = Cart::where('del_flg', 0)
        ->where('user_id', $user->id)
        ->with('product') // カートの商品情報を取得
        ->get();

        return view('carts.index', compact('carts', 'user'));
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

    public function createguest(Product $product)
    {
        $user = Auth::user();
        // カートに商品がすでに存在するか確認
        $cart = Cart::where('user_id', $user->id)
        ->where('product_id', $product->id)
        ->where('del_flg', 0)
        ->first();

        if ($cart) {
        // すでにカートに存在する場合は数量を1増やす
        $cart->number += 1;
        $cart->save();
        } else {
        // カートに存在しない場合は新しく追加
        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->product_id = $product->id;
        $cart->number = 1; // 初期数量を1に設定
        $cart->save();
        }
        // 成功メッセージを返す（リダイレクトはしない）
        return redirect()->back()->with('success', '商品を１点カートに追加しました。');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $user = Auth::user();
        $cart->del_flg = 1;
        $cart->save();

        return redirect()->back()->with('success', 'カートから商品を１件削除しました。');
    }
}
