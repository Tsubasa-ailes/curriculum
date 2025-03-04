@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h5 class="card-title text-center">{{ $user->name }}様の出品履歴</h5>      
        @if($products->isEmpty())
            <p class="no-results">検索結果はありません。</p>
        @else
            @foreach($products as $product)
            <div class="card">
                <div class="card-body">
                    @if($product->image)
                        <img src="{{ asset($product['image']) }}" alt="写真" class="img-fluid">
                    @else
                        <p>写真はありません</p>
                    @endif
                    <h6 class="card-title">{{ $product->name }}</h6>
                    <p class="card-text">価格: {{ $product->price }} 円</p>
                    <p class="card-text">在庫数: @if($product->lot > 0)
                                                        {{ $product->lot }}個
                                                    @else
                                                        <span style="color: red;">在庫切れ</span>
                                                    @endif</p>
                    <p class="card-text">紹介文: {{ $product->description }}</p>
                    
                    <div class="post-actions">
                        <a href="{{ route('products.edit', ['product' => $product->id]) }}">
                            <button class="btn btn-primary btn-xl">編集</button>
                        </a>
                        <a href="{{ route('products.deleteconf', $product->id) }}">
                            <button class="btn btn-primary btn-xl">削除</button>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
@endsection