@extends('layouts.app')

@section('content')
    @if (session('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
    @endif
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">商品詳細</h5>
                <!-- Table displaying post details -->
                <table>
                    <tr>
                        <th>名前</th>
                        <td>{{ $product->name }}</td>
                        <th>価格</th>
                        <td>{{ $product->price }}</td>
                    </tr>
                    <tr>
                        <th>写真</th>
                        <td>
                            @if($product->image)
                            <img src="{{ asset($product['image']) }}" alt="写真" class="img-fluid">
                            @else
                                <p>写真はありません</p>
                            @endif
                        </td>
                        <th>在庫数</th>
                        <td>@if($product->lot > 0)
                                {{ $product->lot }}個
                            @else
                                <span style="color: red;">在庫切れ</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>コメント</th>
                        <td colspan="3">{{ $product->description }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <!-- コメント表示セクション -->
    <div class="mt-5">
        <h5>レビュー一覧</h5>
        @if($product->comments->isEmpty())
            <p>レビューがまだありません。</p>
        @else
            @foreach($product->comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <p><strong>ユーザー:</strong> {{ $comment->user->name }}</p>
                        <!-- 評価を星で表示 -->
                        <p>
                            <strong>評価:</strong>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $comment->rating)
                                    <span class="text-warning">★</span>
                                @else
                                    <span class="text-muted">☆</span>
                                @endif
                            @endfor
                            ({{ $comment->rating }} / 5)
                        </p>
                        <p><strong>コメント:</strong> {{ $comment->comment }}</p>
                        <p class="text-muted">投稿日: {{ $comment->created_at->format('Y年m月d日 H:i') }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>


    <!-- Display the '予約する' button for guest users -->
    @if(Auth::user()->role == 0) <!-- ユーザー区分が0の場合 -->
    @if($product->lot >0)<!-- 在庫数が0以上の場合 -->
    <div class="mt-5">
        <a href="{{ route('orderdetails.createguest', ['product' => $product['id']]) }}">
            <button class="btn btn-primary btn-xl" type="button">今すぐ注文</button>
        </a>
    </div>
    <div class="mt-5">
        <a href="{{ route('carts.createguest', ['product' => $product['id']]) }}">
            <button class="btn btn-primary btn-xl" type="button">カートに入れる</button>
        </a>
    </div>
    @endif
    <div class="mt-5">
        <a href="{{ route('comments.createguest', ['product' => $product['id']]) }}">
            <button class="btn btn-primary btn-xl" type="button">レビューを書く</button>
        </a>
    </div>
    <div class="mt-5">
        <a href="{{ route('products.reportconf', ['product' => $product['id']]) }}">
            <button class="btn btn-primary btn-xl" type="button">報告する</button>
        </a>
    </div>
    @endif
@endsection