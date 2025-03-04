@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h5>以下の商品を注文しますか？</h5>

    @if (!$carts->isEmpty())
        @foreach($carts as $cart)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $cart->product->name }}</h5>
                    <p>
                        <strong>写真:</strong> 
                        <img src="{{ asset($cart->product->image) }}" alt="商品の写真" class="img-fluid" style="max-height: 150px;">
                    </p>
                    <p>
                        <label>購入個数</label>
                        {{-- カートの number を優先して表示 --}}
                        <p>{{ $products[$cart->id]['number'] ?? $cart->number }}</p>
                    </p>
                    <p>
                        <label>合計金額</label>
                        {{-- number を優先して計算 --}}
                        <p>{{ ($products[$cart->id]['number'] ?? $cart->number) * $cart->product->price }} 円</p>
                    </p>
                </div>
            </div>
        @endforeach


    <div class="d-flex justify-content-center mt-4">
        <form action="{{ route('orderdetails.callcomplete') }}" method="POST">
            @csrf
                @foreach($products as $id => $product)
                    <input type="hidden" name="products[{{ $cart->id }}][name]" value="{{ $cart->product->name }}">
                    <input type="hidden" name="products[{{ $cart->id }}][number]" value="{{ $products[$cart->id]['number'] ?? $products->number }}">
                    <input type="hidden" name="products[{{ $cart->id }}][price]" value="{{ $cart->product->price }}">
                    <input type="hidden" name="products[{{ $cart->id }}][image]" value="{{ $cart->product->image }}">
                @endforeach
            <button type="submit" class="btn btn-success">注文を確定する</button>
        </form>
    </div>
    @endif
</div>
@endsection
