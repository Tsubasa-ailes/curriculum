<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Requests\CreateOrder;
use Illuminate\Support\Facades\DB;


class OrderdetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    //カート内の処理の記述ここから
    public function createall()
    {
        //
    }
    public function callconf(CreateOrder $request, Product $product)
    {
        $user = Auth::user();
        $products = $request->input('products', []);
        $carts = Cart::where('del_flg', 0)
        ->where('user_id', $user->id)
        ->with('product') // 商品情報を取得
        ->get();
        // productsの情報をカートの数量で更新
    foreach ($carts as $cart) {
        if (isset($products[$cart->id])) {
            // products配列にカートの数量をセット
            $products[$cart->id]['number'] = $cart->number; // カートの数量を使用
        }
    }
        return view('orderdetails.callconf', compact('carts', 'products'));
    }

    public function callcomplete(Request $request)
    {    
        $products = $request->input('products', []); // リクエストから商品のデータを取得
    
        // 合計金額を計算
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product['number'] * $product['price'];
        }
    
        // トランザクション開始
        DB::beginTransaction();
    
        try {
            // 新しい注文を作成
            $order = new Order;
            $order->user_id = auth()->id(); // ログインユーザーのID
            $order->total_price = $totalPrice; // 合計金額
            $order->save();
    
            // 注文詳細作成と在庫減少処理
            foreach ($products as $cartId => $productData) {
                $cart = Cart::find($cartId);
                $quantity = $productData['number'] ?? $cart->number;
                $product = $cart->product;
    
                // 在庫を減らす処理
                if (!$product->decreaseStock($quantity)) {
                    throw new \Exception("在庫が不足している商品があります: {$product->name}");
                }
    
                // 注文詳細の作成
                $orderDetail = new Orderdetail;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $cart->product_id;
                $orderDetail->quantity = $quantity; // 数量
                $orderDetail->price = $quantity * $cart->product->price;
                $orderDetail->save();
    
                // カートの削除フラグを更新
                $cart->del_flg = 1;
                $cart->save();
            }
    
            // トランザクションの確定
            DB::commit();
    
            return view('orderdetails.callcomplete')->with('success', '注文が完了しました！');
        } catch (\Exception $e) {
            // トランザクションのロールバック
            DB::rollBack();
            return redirect()->route('orderdetails.callconf')
                ->with('error', '注文処理中にエラーが発生しました: ' . $e->getMessage());
        }
    }
        //カート内の記述ここまで

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
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        // 対象の注文詳細を取得
        $orderdetail = Orderdetail::findOrFail($id);

        // 対象の注文を取得
        $order = $orderdetail->order;

        // del_flg を更新
        $orderdetail->del_flg = 1;
        $orderdetail->save();

        // 注文詳細がすべて削除された場合の処理
        if ($order->orderDetails()->where('del_flg', 0)->count() === 0) {
            // 合計金額を0に設定
            $order->total_price = 0;

            // del_flgを1に設定
            $order->del_flg = 1;

            // 注文を保存
            $order->save();

            return redirect()->route('orders.myindex')->with('success', '注文内容がすべて削除されました。');
        }
        
        return redirect()->back()->with('success', '商品を削除しました。');    
    }

    public function myindex()
    {
        
    }

    public function createguest(Product $product)
    {
        return view('orderdetails.createguest', compact('product'));
    }

    public function createconf(CreateOrder $request, Product $product)
    {
        $request->session()->put('form_data', $request->all());

        return view('orderdetails.createconf',[
            'form_data' => $request->all(),
        ], compact('product'));   
    }

    public function createcomplete(Request $request, Product $product)
    {
        $formData = $request->session()->get('form_data', []);

        if (empty($formData) || !isset($formData['quantity'])) {
            return redirect()->route('products.show', ['product' => $product->id])
                ->with('error', __('セッションがタイムアウトしました。再度お試しください。'));
        }

        // トランザクションの開始
        DB::beginTransaction();

        try {

            // 在庫の確認と更新
            if (!$product->decreaseStock($formData['quantity'])) {
                throw new \Exception(__('在庫が不足しています。'));
            }

            // orders テーブルに新しいレコードを作成
            $order = new Order;
            $order->user_id = auth()->id(); // ログイン中のユーザーID
            $order->total_price = $product->price * $formData['quantity'];
            $order->save();

            // orderdetails テーブルにデータを挿入
            $orderdetail = new Orderdetail;
            $orderdetail->order_id = $order->id; // 作成した orders レコードの ID
            $orderdetail->product_id = $product->id;
            $orderdetail->quantity = $formData['quantity'];
            $orderdetail->price = $product->price * $formData['quantity'];
            $orderdetail->save();

            // セッションデータを削除
            $request->session()->forget('form_data');

            // **修正: 購入した商品のみ `del_flg = 1` に更新**
            Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id) // **購入した商品だけを対象**
            ->update(['del_flg' => 1]);


            // トランザクションをコミット
            DB::commit();

            return view('orderdetails.createcomplete', [
                'orderdetail' => $orderdetail,
                'product' => $product,
            ]);
        } catch (\Exception $e) {
            // トランザクションをロールバック
            DB::rollBack();

            return redirect()->route('products.show', ['product' => $product->id])
                ->with('error', __('注文の処理中にエラーが発生しました。もう一度お試しください。'));
        }
    }
}