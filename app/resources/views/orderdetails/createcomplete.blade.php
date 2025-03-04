@extends('layouts.app')

    @section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">注文が完了しました！</h5>
                <table class="table">
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
                                <img src="{{ asset($product['image']) }}" alt="Post Photo" class="img-fluid" style="max-width: 150px;" />
                            @else
                                <p>写真はありません</p>
                            @endif
                        </td>                
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div class="mt-5">
            <h5 class="text-center">購入個数</h5>
                <p>{{ $orderdetail->quantity }}個</p>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('home') }}">
                    <button class="btn btn-primary btn-xl" id="submitButton" type="submit">トップページに戻る</button>
                </a>
            </div>
        </div>
    </div>
    @endsection