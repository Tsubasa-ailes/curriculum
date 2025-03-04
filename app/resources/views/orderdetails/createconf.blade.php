@extends('layouts.app')
    @section('content')
    <div class="container">
        <h2>{{ __('確認画面') }}</h2>
                @if($product->image)
                    <img src="{{ asset($product['image']) }}" alt="写真" class="img-fluid">
                @else
                    <p>写真はありません</p>
                @endif
            <form action="{{ route('orderdetails.createcomplete', ['product' => $product->id]) }}" method="post">
                @csrf
                <div class="form-group">
                    <label>{{ __('購入個数') }}</label><br>
                    <p>{{ $form_data['quantity'] }}個</p>
                </div>
                <input type="hidden" name="quantity" value="{{ $form_data['quantity'] }}">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('注文する（最終確認！）') }}</button>
                </div>
            </form>
    </div>
    @endsection