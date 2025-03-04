@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h5 class="card-title text-center">あなたのカート</h5>

    <div class="card">
        <div class="card-body">
            @if($carts->isEmpty())
                <p>カートに商品が入っていません。</p>
            @else
                @foreach($carts as $cart)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5>{{ $cart->product->name }}</h5>
                            <p>
                                <strong>写真:</strong> 
                                <img src="{{ asset($cart->product->image) }}" alt="商品の写真" class="img-fluid" style="max-height: 150px;">
                            </p>
                            <form action="{{ route('orderdetails.createconf', ['product' => $cart->product->id]) }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="quantity_{{ $cart->id }}" class="col-md-4 col-form-label text-md-right">購入個数</label>
                                    <div class="col-md-6">
                                    <input 
                                        type="number" 
                                        id="quantity_{{ $cart->id }}" 
                                        name="quantity" 
                                        class="form-control number-input @error('quantity') is-invalid @enderror" 
                                        value="{{ old('quantity', $cart->number) }}"  
                                        min="1" 
                                        max="{{ $cart->product->lot }}" 
                                        data-price="{{ $cart->product->price }}">
                                        @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="totalPrice_{{ $cart->id }}" class="col-md-4 col-form-label text-md-right">合計金額</label>
                                    <div class="col-md-6">
                                        <p id="totalPrice_{{ $cart->id }}" class="form-control-plaintext">
                                            {{ $cart->product->price * $cart->number }} 円
                                        </p>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">今すぐ購入</button>
                            </form>

                            <form action="{{ route('carts.destroy', ['cart' => $cart->id]) }}" method="POST" style="margin-top: 10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">カートから外す</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    @if(!$carts->isEmpty())
        <div class="d-flex justify-content-center mt-4">
            <form action="{{ route('orderdetails.callconf')}}" method="POST">
                @csrf
                @foreach($carts as $cart)
                    <input type="hidden" name="products[{{ $cart->id }}][name]" value="{{ $cart->product->name }}">
                    <input type="hidden" name="products[{{ $cart->id }}][number]" id="hiddenNumber_{{ $cart->id }}" value="{{ $cart->number }}">
                    <input type="hidden" name="products[{{ $cart->id }}][price]" value="{{ $cart->product->price }}">
                    <input type="hidden" name="products[{{ $cart->id }}][image]" value="{{ $cart->product->image }}">
                @endforeach
                <button type="submit" class="btn btn-primary">レジに進む</button>
            </form>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const numberInputs = document.querySelectorAll('.number-input');

        // 数量変更時に合計金額を更新
        numberInputs.forEach(input => {
            input.addEventListener('input', function () {
                const price = parseFloat(this.dataset.price);
                const quantity = parseInt(this.value);
                const cartId = this.id.split('_')[1];
                const totalPriceElem = document.getElementById('totalPrice_' + cartId);
                const hiddenField = document.getElementById('hiddenNumber_' + cartId);

                if (!isNaN(price) && !isNaN(quantity)) {
                    const totalPrice = price * quantity;
                    totalPriceElem.textContent = totalPrice.toLocaleString() + ' 円';

                    // 隠しフィールドも更新
                    if (hiddenField) {
                        hiddenField.value = quantity;
                    }
                }
            });
        });
    });
</script>
@endsection
