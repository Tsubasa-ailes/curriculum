@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">商品編集の確認</h5>

            <!-- 写真 -->
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">{{ __('写真') }}</label>
                <div class="col-md-6">
                    @if(!empty($data['image']))
                        <img src="{{ asset('storage/' . $data['image']) }}" alt="商品写真" class="img-preview">
                    @elseif($product->image)
                        <img src="{{ asset($product->image) }}" alt="商品写真" class="img-preview">
                    @else
                        <p>写真は設定されていません。</p>
                    @endif
                </div>
            </div>

            <!-- 商品名 -->
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">{{ __('商品名') }}</label>
                <div class="col-md-6">
                    <p class="form-control-plaintext">{{ $request['name'] }}</p>
                </div>
            </div>

            <!-- 価格 -->
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">{{ __('価格') }}</label>
                <div class="col-md-6">
                    <p class="form-control-plaintext">{{ $request['price'] }}</p>
                </div>
            </div>

            <!-- 在庫数 -->
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">{{ __('在庫数') }}</label>
                <div class="col-md-6">
                    <p class="form-control-plaintext">{{ $request['people'] }}</p>
                </div>
            </div>

            <!-- 紹介文 -->
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">{{ __('紹介文') }}</label>
                <div class="col-md-6">
                    <p class="form-control-plaintext">{{ $request['description'] }}</p>
                </div>
            </div>

            <!-- ボタン -->
            <div class="d-flex justify-content-between mt-4">
                <!-- 修正に戻るボタン -->
                <form action="{{ route('products.edit', ['product' => $product->id]) }}" method="GET">
                    <button type="submit" class="btn btn-secondary">修正に戻る</button>
                </form>

                <!-- 更新確定ボタン -->
                <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- 確認データをhiddenで送信 -->
                    <input type="hidden" name="name" value="{{ $request['name'] }}">
                    <input type="hidden" name="price" value="{{ $request['price'] }}">
                    <input type="hidden" name="people" value="{{ $request['people'] }}">
                    <input type="hidden" name="description" value="{{ $request['description'] }}">
                    <input type="hidden" name="image" value="{{ $request['image'] }}">
                    <button type="submit" class="btn btn-primary">更新を確定する</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection