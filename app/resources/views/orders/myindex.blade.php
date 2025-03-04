@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h5 class="text-center">注文履歴</h5>

    @if($orders->isEmpty())
        <p class="text-center">まだ注文履歴がありません。</p>
    @else
        @foreach($orders as $order)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>注文日: {{ $order->created_at->format('Y年m月d日 H:i') }}</h5>
                    <p><strong>合計金額:</strong> {{ number_format($order->total_price) }} 円</p>

                    <h6>注文詳細:</h6>
                    <ul>
                        @foreach($order->orderDetails as $detail)
                            <li>
                                <strong>{{ $detail->product->name }}</strong>  
                                （数量: {{ $detail->quantity }}、小計: {{ number_format($detail->price) }} 円）
                            </li>
                        @endforeach
                    </ul>
                    <!-- 編集ボタン -->
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">注文内容の確認・変更</a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
