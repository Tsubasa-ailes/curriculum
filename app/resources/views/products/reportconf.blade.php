@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h5 class="text-center">商品に関する違反報告</h5>

    <form action="{{ route('products.reportcomp') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="product">対象の商品</label>
            <input type="text" id="product" class="form-control" value="{{ $product->name }}" readonly>
        </div>
        
        <div class="form-group mt-3">
            <label for="reason">違反内容</label>
            <select id="reason" name="reason" class="form-control" required>
                <option value="">違反の理由を選択してください</option>
                <option value="1">虚偽情報が含まれている</option>
                <option value="2">不適切な内容が含まれている</option>
                <option value="3">その他の理由</option>
            </select>
        </div>
        
        <div class="form-group mt-3">
            <label for="details">詳細 (任意)</label>
            <textarea id="details" name="details" class="form-control" rows="4" placeholder="違反に関する詳細をご記入ください (任意)"></textarea>
        </div>

        <input type="hidden" name="product_id" value="{{ $product->id }}">
        
        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-danger">報告する</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">キャンセル</a>
        </div>
    </form>
</div>
@endsection
