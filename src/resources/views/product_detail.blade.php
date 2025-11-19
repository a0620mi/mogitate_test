@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_detail.css') }}" />
@endsection

@section('content')
<div class="container">
    <h1 class="page-title">商品一覧＞ {{ $product->name }}</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="detail-form">
        @csrf
        <div class="form-grid">
            <div class="form-group image-upload-area">
                <label for="image_path"></label>
                <div class="current-image">
                    @if ($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="detail-image-preview">
                    @else
                    <div class="no-image-placeholder">画像なし</div>
                    @endif
                </div>
                <input type="file" name="image_path" id="image_path">
            </div>

            <div class="form-fields">

                <div class="form-group">
                    <label for="name">商品名</label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name', $product->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="price">値段</label>
                    <input type="number" name="price" id="price"
                        value="{{ old('price', $product->price) }}" required>
                </div>

                <div class="form-group radio-group">
                    <label>季節</label>
                    @foreach ($seasons as $season)
                    <label>
                        <input type="radio" name="season_id" value="{{ $season->id }}"
                            @if ($product->seasons->contains($season->id)) checked @endif>
                        {{ $season->name }}
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group full-width">
                <label for="description">商品説明</label>
                <textarea name="description" id="description" rows="5" required>
                {{ old('description', $product->description) }}
                </textarea>
            </div>

        </div>

        <div class="action-buttons">
            <a href="{{ url('/products') }}" class="back-btn">戻る</a>
            <button type="submit" class="submit-btn">変更を保存</button>
            <button type="button" class="delete-btn">
                <i class="fas fa-trash">🗑️</i>
            </button>
        </div>

    </form>
</div>
@endsection