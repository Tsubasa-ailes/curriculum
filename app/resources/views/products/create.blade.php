@extends('layouts.app')
    @section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title text-center">出品フォーム</h5>
            <div class="panel-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <form action="{{ route('products.createconf') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- value属性追加して -->
                <div class="form-group row">
                    <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('写真を選択') }}</label>
                    <div class="col-md-6">
                        <input id="image" type="file" class="form-control" name="image" value="{{ old('image') }}" enctype="multipart/form-data">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('商品名') }}</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('価格') }}</label>
                    <div class="col-md-6">
                        <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lot" class="col-md-4 col-form-label text-md-right">{{ __('出荷個数') }}</label>
                    <div class="col-md-6">
                        <input id="lot" type="number" class="form-control" name="lot" value="{{ old('lot') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('紹介文') }}</label>
                    <div class="col-md-6">
                        <textarea id="description" class="form-control" name="description">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary btn-xl" id="submitButton" type="submit">{{ __('出品する') }}</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    @endsection