@extends('layouts.app')

@section('content')
<div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">マイページ</h5>
                
                <!-- 名前とプロフィール写真を横並びに -->
                <div class="name-photo d-flex align-items-center">
                    @if($user->icon)
                        <img src="{{ asset($user->icon) }}" alt="User Photo" class="img-fluid rounded-circle" style="width: 100px; height: 100px;" />
                    @else
                        <img src="{{ asset('img/default-avatar.png') }}" alt="Default Avatar" class="img-fluid rounded-circle" style="width: 100px; height: 100px;" />
                    @endif

                    <!-- 名前 -->
                    <span>{{ $user->name }}</span>
                </div>

                <table class="table">
                    <tr>
                        <th>メールアドレス</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                </table>
            </div>
            <!-- ボタンセクション -->
            <div class="d-flex">
                    <a href="{{ route('users.edit', ['user' => $user->id]) }}">
                        <button class="btn btn-primary btn-xl" type="submit">プロフィール編集</button>
                    </a>

                    @if(Auth::user()->role == 0) <!-- ユーザー区分が0の場合 -->
                    <a href="{{ route('orders.myindex') }}">
                        <button class="btn btn-primary btn-xl" type="submit">注文履歴</button>
                    </a>
                    <a href="{{ route('carts.index') }}">
                        <button class="btn btn-primary btn-xl" type="submit">カート</button>
                    </a>
                    @endif

                    @if(Auth::user()->role == 1) <!-- ユーザー区分が1の場合 -->
                    <a href="{{ route('products.create') }}">
                        <button class="btn btn-primary btn-xl" type="submit">出品</button>
                    </a>
                    <a href="{{ route('products.myindex') }}">
                        <button class="btn btn-primary btn-xl" type="submit">出品履歴</button>
                    </a>
                    @endif
            </div>
        </div>
    </div>
@endsection             