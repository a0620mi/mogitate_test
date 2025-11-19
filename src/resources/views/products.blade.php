@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products.css') }}" />
@endsection

@section('content')
<div class="container">

    <div class="header-section">
        <h1 class="page-title">商品一覧</h1>

        <a href="{{ route('products.create') }}" method="post" class="add-product-btn">
            <i class="fas fa-plus"></i> 商品を追加
        </a>
    </div>

    <div class="content-body">
        <form action="/products" method="GET" class="sidebar-form">
            <div class="search-box">
                <input type="text" name="keyword"
                    placeholder="商品名で検索"
                    value="{{ request('keyword') }}"
                    class="search-input">
                <button class="search-btn" type="submit">検索</button>
            </div>
            <p class="sort-label">価格順で表示</p>
            <div class="sort-box">
                @php
                $currentQuery = http_build_query(request()->except(['sort', 'page']));
                $baseUrl = '/products' . (empty($currentQuery) ? '?' : '?' . $currentQuery . '&');
                @endphp
                <select class="sort-select" onchange="window.location.href = this.value;">
                    <option value="{{ $baseUrl }}" @unless(request('sort')) selected @endunless>
                        並べ替え
                    </option>
                    <option value="{{ $baseUrl }}sort=price_desc" @selected(request('sort')=='price_desc' )>
                        価格の高い順
                    </option>
                    <option value="{{ $baseUrl }}sort=price_asc" @selected(request('sort')=='price_asc' )>
                        価格の低い順
                    </option>
                </select>

                @if ($sortData['currentSort'])
                <div class="filter-tags">
                    <div class="active-tag">
                        <span>{{ $sortData['sortText'] }}</span>
                        <a href="{{ $sortData['resetUrl'] }}" class="tag-reset-btn">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </form>

        <div class="products-list">
            <div class="grid grid-cols-3 gap-6">
                @foreach ($products as $product)
                <a href="{{ url('/products/' . $product->id) }}" class="product-card-link">
                    <div class="product-card">
                        <img src="{{ asset('storage/' . $product->image_path) }}"
                            alt="{{ $product->name }}"
                            class="product-card__image">
                        <div class="product-info-row">
                            <h3 class="product-card__name">{{ $product->name }}</h3>
                            <p class="product-card__price">¥{{ number_format($product->price) }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="flex justify-center mt-8">
                @if ($products->hasPages())
                <div class="pagination custom-pagination">
                    {{ $products->Links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection