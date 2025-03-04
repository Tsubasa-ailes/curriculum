<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Report;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $formData = $request->session()->get('form_data');
        if (!$formData) {
            return redirect()->back()->withErrors('フォームデータが存在しません。');
        }
        $product = new Product;
        $product->image = $formData['image'];
        $product->name = $formData['name'];
        $product->price = $formData['price'];
        $product->lot = $formData['lot'];
        $product->description = $formData['description'];

        $product->user_id = auth()->id(); // ここでユーザーIDを設定
        $product->save();

        $request->session()->forget('form_data');
        
        return redirect()->route('products.myindex')->with([
            'user' => $user,
            'product' => $product,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->load(['comments' => function ($query) {
            $query->where('del_flg', 0)->orderBy('created_at', 'desc');
        }]);
    
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function editconf(Request $request, Product $product)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('temp', 'public');
            $validatedData['image'] = $imagePath;
        }

        return view('products.editconf', compact('product', 'request'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // 商品情報を更新
    $product->name = $request['name'];
    $product->price = $request['price'];
    $product->lot = $request['people'];
    $product->description = $request['description'];

    // 新しい画像を保存
    if (!empty($request['image'])) {
        $tempPath = 'public/' . $request['image'];
        $newPath = 'images/products/' . basename($request['image']);
        Storage::move($tempPath, 'public/' . $newPath);
        $product->image = $newPath;
    }

    $product->save();

    return redirect()->route('products.myindex', ['product' => $product->id])->with('success', '商品が更新されました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function deleteconf(Product $product)
    {
        return view('products.deleteconf', compact('product'));
    }

    public function destroy(Product $product)
    {
        $user = Auth::user();
        $columns = ['name', 'price', 'image', 'lot', 'description'];
        $product->del_flg = 1;
        $product->save();      

        return redirect()->route('products.myindex');   
    }

    public function myindex()
    {
        $user = Auth::user();
        $products = $user->products()->where('del_flg', 0)->get();

        return view('products.myindex', compact('user', 'products'));
    }

    public function createconf(Request $request)
    {
        // 画像ファイルがアップロードされているか確認
        if ($request->hasFile('image')) {
        // 拡張子つきでファイル名を取得
        $imageName = $request->file('image')->getClientOriginalName();

        // 拡張子のみ
        $extension = $request->file('image')->getClientOriginalExtension();

        // 新しいファイル名を生成（元のファイル名_ランダムの英数字.拡張子）
        $newPhotoName = pathinfo($imageName, PATHINFO_FILENAME) . "_" . uniqid() . "." . $extension;

        // ファイルを保存（public/img/tmp に移動）
        $request->file('image')->move(public_path() . "/img/tmp", $newPhotoName);

        // 保存したファイルパスを取得
        $photoPath = "/img/tmp/" . $newPhotoName;

        // セッションにフォームデータを保存
        $formData = $request->except('image');  // 写真以外のデータを保持
        $formData['image'] = $photoPath;  // 写真のパスを追加
        $request->session()->put('form_data', $formData);

        // 確認画面に遷移
        return view('products.createconf', [
            'form_data' => $formData,
            'newPhotoName' => $newPhotoName,
        ]);
        } else {
        // ファイルがアップロードされていない場合
        return back()->withErrors(['image' => '写真は必須です。']);
        }
    }

    public function reportconf(Request $request, Product $product)
    {
        return view('products.reportconf', compact('product'));
    }

    public function reportcomp(Request $request, Product $product)
    {
        Report::create([
            'product_id' => $request->product_id,
            'reason' => $request->reason,
            'details' => $request->details ?? '',
            'user_id' => auth()->id(),
            'del_flg' => 0,
        ]);

        return redirect()->route('products.show', $request->product_id)
            ->with('success', '違反報告が送信されました。');
    }
}