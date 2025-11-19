@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_create.css') }}" />
@endsection

@section('content')
<div class="registration-container">
    <h1 class="page-title">商品登録</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="registration-form">
        @csrf
        <div class="form-group">
            <label for="name" class="form-label">
                商品名
                <span class="required-tag">必須</span>
            </label>
            <input type="text" id="name" name="name"
                class="form-input" placeholder="商品名を入力"
                value="{{ old('name') }}">
            @error('name')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="price" class="form-label">
                値段
                <span class="required-tag">必須</span>
            </label>
            <input type="number" id="price" name="price"
                class="form-input" placeholder="値段を入力"
                value="{{ old('price') }}">
            @error('price')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="image_path" class="form-label">
                商品画像
                <span class="required-tag">必須</span>
            </label>
            <input type="file" id="image_path" name="image_path" class="file-input">
            @error('image_path')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                季節
                <span class="required-tag">必須</span>
                <span class="info-tag">複数選択可</span>
            </label>
            <div class="radio-group">
                @php
                $seasons = ['春', '夏', '秋', '冬'];
                @endphp
                @foreach($seasons as $season)
                <label class="radio-label">
                    <input type="checkbox" name="seasons[]" value="{{ $season }}">
                    {{ $season }}
                </label>
                @error('seasons')
                <p class="error-message">{{ $message }}</p>
                @enderror
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">
                商品説明
                <span class="required-tag">必須</span>
            </label>
            <textarea id="description" name="description"
                class="form-textarea" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions">
            <button type="button" onclick="window.history.back()" class="btn btn-back">
                戻る
            </button>
            <button type="submit" class="btn btn-submit">
                登録
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        var imagePreview = document.getElementById('image-preview');

        reader.onload = function() {
            if (reader.readyState == 2) {
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
            }
        }

        if (event.target.files.length > 0) {
            reader.readAsDataURL(event.target.files[0]);
        } else {
            imagePreview.style.display = 'none';
            imagePreview.src = '#';
        }
    }
</script>
@endsection