<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<title>Anuzom | 日用品、ファッション、家電から食品まで | アヌゾム</title>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="container mt-5">
                    <h5>商品検索 <i class="fas fa-search"></i></h5>
                    <form action="{{ route('display.search') }}" method="GET" class="mb-4">
                        <div class="input-group mb-2">
                            <input type="text" name="query" class="form-control" placeholder="商品を検索" value="{{ request('query') }}">
                        </div>
                        <div class="input-group mb-2">
                            <label class="input-group-text">最小価格</label>
                            <select name="min_price" class="form-control">
                                <option value="">指定なし</option>
                                <option value="500" {{ request('min_price') == 500 ? 'selected' : '' }}>500円</option>
                                <option value="1000" {{ request('min_price') == 1000 ? 'selected' : '' }}>1000円</option>
                                <option value="5000" {{ request('min_price') == 5000 ? 'selected' : '' }}>5000円</option>
                                <option value="10000" {{ request('min_price') == 10000 ? 'selected' : '' }}>10000円</option>
                                <option value="50000" {{ request('min_price') == 50000 ? 'selected' : '' }}>50000円</option>
                                <option value="100000" {{ request('min_price') == 100000 ? 'selected' : '' }}>100000円</option>
                            </select>
                        </div>

                        <div class="input-group mb-2">
                            <label class="input-group-text">最大価格</label>
                            <select name="max_price" class="form-control">
                                <option value="">指定なし</option>
                                <option value="500" {{ request('max_price') == 500 ? 'selected' : '' }}>500円</option>
                                <option value="1000" {{ request('max_price') == 1000 ? 'selected' : '' }}>1000円</option>
                                <option value="5000" {{ request('max_price') == 5000 ? 'selected' : '' }}>5000円</option>
                                <option value="10000" {{ request('max_price') == 10000 ? 'selected' : '' }}>10000円</option>
                                <option value="50000" {{ request('max_price') == 50000 ? 'selected' : '' }}>50000円</option>
                                <option value="100000" {{ request('max_price') == 100000 ? 'selected' : '' }}>100000円</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> 検索
                        </button>
                    </form>
                </div>
                <h5 class="card-title text-center">話題の商品</h5>
                <div id="ProductsList" class="row">
                    @if(empty($products))
                        <p>検索結果はありません。</p>
                    @else
                    @foreach($products as $product)
                    <div class="col-md-12"> <!-- 1列に変更 -->
                        <div class="post-card">
                            <!-- 投稿の写真 -->
                            <div class="post-photo">
                                @if($product['image'])
                                <img src="{{ asset($product['image']) }}" 
                                    alt="Post Photo" 
                                    class="img-fluid" 
                                    style="width: 100%; height: 200px; object-fit: contain; border-radius: 8px;">
                                @else
                                    <p>写真はありません</p>
                                @endif
                            </div>

                            <!-- 投稿の詳細情報 --> 
                            <h5>{{ $product['name'] }}</h5>
                            <p><strong>価格:</strong> {{ $product['price'] }}円</p>
                            <p><strong>在庫数:</strong> @if($product->lot > 0)
                                                            {{ $product->lot }}個
                                                        @else
                                                            <span style="color: red;">在庫切れ</span>
                                                        @endif</p>
                            <p><strong>紹介文:</strong> {{ $product['description'] }}</p>
                
                            <!-- 詳細ページへのリンク -->
                            <a href="{{ route('products.show', ['product' => $product['id']]) }}">
                                <button class="btn btn-primary btn-xl">詳細</button>
                            </a>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
