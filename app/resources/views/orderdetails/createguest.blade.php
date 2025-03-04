@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">予約受付フォーム</h5>
            <div class="container">
                @if($product->image)
                    <img src="{{ asset($product['image']) }}" alt="写真" class="img-fluid">
                @else
                    <p>写真はありません</p>
                @endif
                <p>商品名: {{ $product->name }}</p>
                <p>価格: {{ $product->price }} 円</p>
                <p>在庫数: {{ $product->lot }}</p>
                <p>紹介文: {{ $product->description }}</p>
            </div>
        </div>

        <!-- 購入フォーム -->
        <form action="{{ route('orderdetails.createconf', ['product' => $product['id']]) }}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="quantity" class="col-md-4 col-form-label text-md-right">購入個数</label>
                <div class="col-md-6">
                    <input 
                        type="number" 
                        id="quantity" 
                        name="quantity" 
                        class="form-control @error('quantity') is-invalid @enderror"
                        value="1" 
                        min="1" 
                        max="{{ $product->lot }}" 
                        oninput="updateTotalPrice()">
                    @error('quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="totalPrice" class="col-md-4 col-form-label text-md-right">合計金額</label>
                <div class="col-md-6">
                    <p id="totalPrice" class="form-control-plaintext">{{ $product->price }} 円</p>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">注文する</button>
            </div>
        </form>
    </div>
</div>

<!-- 合計金額を計算するJavaScript -->
<script>
    const price = {{ $product->price }};
    
    function updateTotalPrice() {
        const quantity = document.getElementById('quantity').value;
        const totalPrice = price * quantity;
        document.getElementById('totalPrice').textContent = totalPrice + ' 円';
    }
</script>
@endsection
