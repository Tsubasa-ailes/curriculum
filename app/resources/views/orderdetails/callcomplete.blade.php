@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <div class="card">
        <div class="card-body">
            <h1 class="text-success">注文が完了しました！</h1>
            <p class="mt-3">ご注文ありがとうございます。</p>
            <p class="mt-2">注文内容の確認メールをお送りしましたので、ご確認ください。</p>
            <p class="mt-3">
                商品は通常3〜5営業日以内に発送されます。発送完了後に再度ご連絡いたします。
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-4">ホームに戻る</a>
        </div>
    </div>
</div>
@endsection
