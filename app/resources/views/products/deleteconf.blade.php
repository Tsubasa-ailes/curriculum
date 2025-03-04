@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">投稿の削除</h5>

            <table class="table table-bordered">
                <tr>
                    <th>商品名</th>
                    <td>{{ $product->name }}</td>
                    <th>価格</th>
                    <td>{{ $product->price }}</td>
                </tr>
                <tr>
                    <th>写真</th>
                    <td>
                        @if($product->image)
                            <img src="{{ asset($product['image']) }}" alt="Product Photo" class="img-fluid" style="max-width: 150px;"/>
                        @else
                            <p>写真はありません</p>
                        @endif
                    </td>
                    <th>在庫数</th>
                    <td>{{ $product->lot }}</td>
                </tr>
                <tr>
                    <th>紹介文</th>
                    <td>{{ $product->description }}</td>                    
                </tr>
            </table>
        </div>
    </div>

    <!-- 中央に配置された削除確認セクション -->
    <div class="d-flex justify-content-center mt-5">
        <div class="text-center">
            <h5>削除するとこの商品はユーザーに表示されなくなります！</h5>
            <h5>本当に削除しますか？</h5>
            <form action="{{ route('products.destroy', ['product' => $product['id']]) }}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-xl" id="submitButton" type="submit">削除する</button>
            </form>
        </div>
    </div>

</div>
@endsection