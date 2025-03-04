<title>プロフィール編集</title>
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">プロフィール編集</h5>
            <!-- プロフィール編集フォーム -->
            <form action="{{ route('users.update', ['user' => $user['id']]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- 名前 -->
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('名前') }}</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Eメール -->
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Eメールアドレス') }}</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- プロフィール写真 -->
                <div class="form-group row">
                    <label for="icon" class="col-md-4 col-form-label text-md-right">{{ __('プロフィール写真') }}</label>
                    <div class="col-md-6">
                        <input id="icon" type="file" class="form-control @error('icon') is-invalid @enderror" name="icon">
                        <!-- 現在のプロフィール写真 -->
                        @if($user->icon)
                        <div class="mt-3 d-flex align-items-center">
                            <p>現在のプロフィール写真:</p>
                            <img src="{{ asset($user->icon) }}" alt="Profile Photo" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        @else
                        <p>プロフィール写真は設定されていません。</p>
                        @endif
                    </div>
                </div>

                <!-- 変更ボタン -->
                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-primary btn-xl" id="submitButton" type="submit">変更する</button>
                </div>
            </form>

            <!-- 退会ボタン -->
            <div class="btn-container">
                <a href="{{ route('users.deleteconf', ['user' => $user['id']]) }}">
                    <button class="btn btn-danger btn-xl" id="submitButton" type="submit">アカウント削除</button>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection