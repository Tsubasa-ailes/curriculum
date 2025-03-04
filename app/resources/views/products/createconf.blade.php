@extends('layouts.app')
    @section('content')
    <div class="container">
    <h2>{{ __('確認画面') }}</h2>
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>{{ __('写真') }}</label>
            @if(isset($form_data['image']))
            <img src="{{ asset($form_data['image']) }}" alt="選択された写真" class="img-fluid">
            @else
                <p>写真はありません。</p>
            @endif
        </div>
        
        <div class="form-group">
            <label>{{ __('商品名') }}</label>
            <p>{{ $form_data['name'] }}</p>
        </div>

        <div class="form-group">
            <label>{{ __('価格') }}</label>
            <p>{{ $form_data['price'] }}</p>
        </div>

        <div class="form-group">
            <label>{{ __('出荷個数') }}</label>
            <p>{{ $form_data['lot'] }}</p>
        </div>

        <div class="form-group">
            <label>{{ __('紹介文') }}</label>
            <p>{{ $form_data['description'] }}</p>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{ __('出品(最終確認！)') }}</button>
            <a href="{{ route('products.create') }}" class="btn btn-secondary">{{ __('修正') }}</a>
        </div>
    </form>  
    </div>
@endsection