@extends('layouts.app')

@section('content')
<div class="container">
    <h1>コメント作成: {{ $product->name }}</h1>
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="form-group">
            <label for="rating">評価 (1～5):</label>
            <select name="rating" id="rating" class="form-control">
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label for="comment">コメント:</label>
            <textarea name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" rows="5"></textarea>
                @error('comment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
        <button type="submit" class="btn btn-primary">コメントを追加</button>
    </form>
</div>
@endsection