@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">商品内容編集ページ</h5>

            <!-- エラーメッセージ表示 -->
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('products.editconf', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- 写真の表示部分 -->
                <div class="form-group row">
                    <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('写真を選択') }}</label>
                    <div class="col-md-6">
                        @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="投稿画像" class="img-preview">
                        @endif
                        <input id="image" type="file" class="form-control mt-2" name="image" accept="image/*">
                    </div>
                </div>

                <!-- 商品名入力 -->
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('商品名') }}</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}">
                    </div>
                </div>

                <!-- 価格入力 -->
                <div class="form-group row">
                    <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('価格') }}</label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input id="price" type="text" class="form-control" name="price" value="{{ old('price', $product->price) }}">
                        <span class="ml-2">円</span>
                    </div>
                </div>

                <!-- 在庫数入力 -->
                <div class="form-group row">
                    <label for="people" class="col-md-4 col-form-label text-md-right">{{ __('在庫数') }}</label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input id="people" type="number" class="form-control" name="people" value="{{ old('lot', $product->lot) }}">
                        <span class="ml-2">個</span>
                    </div>
                </div>

                <!-- 紹介文入力 -->
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('紹介文') }}</label>
                    <div class="col-md-6">
                        <textarea id="description" class="form-control" name="description">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <!-- 修正ボタン -->
                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-primary btn-xl" id="submitButton" type="submit">{{ __('修正する') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
