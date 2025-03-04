@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h5 class="text-center">注文内容の確認・変更</h5>

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card mb-3">
            <div class="card-body">
                <h5>注文日: {{ $order->created_at->format('Y年m月d日 H:i') }}</h5>
                <p><strong>合計金額 (注文時):</strong> <span id="initial-total-price">{{ number_format($order->total_price) }} 円</span></p>
                <p><strong>合計金額 (現在):</strong> <span id="dynamic-total-price">{{ number_format($order->filtered_total_price) }} 円</span></p>

                <h6>注文詳細:</h6>
                <ul class="list-group">
                    @foreach($order->orderDetails as $detail)
                    <li class="list-group-item" data-unit-price="{{ $detail->product->price }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $detail->product->name }}</strong>
                                    <p>価格(1点あたり): {{ number_format($detail->product->price) }} 円</p>
                                    <p>数量: 
                                        <input type="number" name="quantities[{{ $detail->id }}]" 
                                            value="{{ old('quantities.' . $detail->id, $detail->quantity) }}" 
                                            min="1" class="form-control d-inline-block quantity-input @error('quantities.' . $detail->id) is-invalid @enderror" 
                                            style="width: 80px;" oninput="updateTotalPrice()">

                                        @error('quantity' . 'quantities.' . $detail->id)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>
                                </div>
                                <!-- 削除フォーム（保存フォーム内に含める） -->
                                <button type="button" class="btn btn-danger btn-sm delete-item-btn" data-id="{{ $detail->id }}" onclick="deleteItem(this)">削除</button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <button type="submit" class="btn btn-success">保存</button>
        <a href="{{ route('orders.myindex') }}" class="btn btn-secondary">キャンセル</a>
    </form>

<script>
    function updateTotalPrice() {
        let totalPrice = 0;

        // 各商品の単価と数量を取得して合計を計算
        document.querySelectorAll('.quantity-input').forEach(function(input) {
            let quantity = parseInt(input.value, 10) || 0;
            let price = parseInt(input.closest('li').getAttribute('data-unit-price'), 10); // 単価を取得
            totalPrice += quantity * price;
        });

        // 合計金額を更新
        document.getElementById('dynamic-total-price').textContent = totalPrice.toLocaleString() + ' 円';
    }


    function deleteItem(button) {
        if (confirm('この商品を削除しますか？')) {
            // 削除対象の商品IDを取得
            let detailId = button.getAttribute('data-id');
            
            // 削除フォームを動的に作成して送信
            let form = document.createElement('form');
            form.action = `/orderdetails/${detailId}`;
            form.method = 'POST';
            
            let csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            let methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            
            document.body.appendChild(form);
            form.submit();
        }
    }

    // ページロード時に合計金額を更新
    window.onload = updateTotalPrice;
</script>

@endsection
