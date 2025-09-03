@extends('layout.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')

<div class="product-form">
    <div class="product-form__left">
        <h2 class="product-form__title">商品一覧</h2>

        {{-- 商品検索フォーム --}}
        <form class="search" action="{{ route('products.index') }}" method="GET">
        <div class="search-product">
            <input class="search-text" type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索">
            <button class="search-button" type="submit">検索</button>
        </div>

        {{-- 並び替え --}}
        <div class="sort">
            <h4 class="search-sort">価格順で表示</h4>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="">価格で並べ替え</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>価格が低い順</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>価格が高い順</option>
            </select>
        </div>
        </form>

        {{-- タグ表示 --}}
        @if(request('sort'))
        <div class="sort-tag">
            {{ request('sort') == 'asc' ? '価格が低い順' : '価格が高い順' }}
            <a class="sort-tag__show" href="{{ route('products.index', array_merge(request()->except('sort'))) }}">×</a>
        </div>
        @endif
    </div>

    <div class="product-form__right">
        {{-- 商品追加ボタン --}}
        <div class="product-create">
            <a class="product-create__button" href="{{ route('products.create') }}">+ 商品を追加</a>
        </div>

        {{-- 商品一覧 --}}
        <div class="products">
            @foreach($products as $product)
            <div class="product-card">
                <a class="product-card__show" href="{{ route('products.show', $product->id) }}">
                    @if($product->image)
                    <img class="product-image"
                    src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}">
                    @endif
                    <div class="product-detail">
                        <span class="product-name">{{ $product->name }}</span>
                        <span class="product-price">¥{{ $product->price }}</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        {{-- ページネーション --}}
        <div class="pagination">
        {{ $products->links('vendor.pagination.bootstrap-4') }}
        </div>

    </div>

</div>

@endsection