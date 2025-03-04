@section('content')
@extends('layouts.app')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">マイページ</h5>
            <table>
                <tr>
                    <th>名前</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $user->email }}</td>
                <tr>
                    <th>プロフィール写真</th>
                    <td>
                        @if($user->icon)
                            <img src="{{ asset($user->icon) }}" alt="User Photo" class="img-fluid" style="max-width: 150px;"/>
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
    <h5>アカウント削除するとユーザー情報は全て削除され、購入履歴の照会ができなくなります！</h5>
    <h5>本当に退会しますか？</h5>
    <form action="{{ route('users.destroy', ['user' => $user['id']]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-primary btn-xl" id="submitButton" type="submit">退会する</button>
    </form>
    </div>
</div>
@endsection