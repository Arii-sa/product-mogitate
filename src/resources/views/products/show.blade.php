@extends('layout.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css')}}">
@endsection

@section('content')

<div class="product-detail">

    <h2 class="product-detail__title">商品詳細・編集</h2>

    {{-- バリデーションエラー表示 --}}
    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color:red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 更新フォーム --}}
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <div class="product-detail__content">
        {{-- 左側：画像 --}}
            <div class="product-detail__image">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @endif
                <input type="file" id="image" name="image" accept=".png,.jpeg,.jpg">
                @error('image')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

        <div class="product-detail__info">

        {{-- 商品名 --}}
        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}">
            @error('name')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        {{-- 値段 --}}
        <div class="form-group">
            <label for="price">値段</label>
            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}">
            @error('price')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        {{-- 季節（複数選択可） --}}
            <div class="form-group">
            <label for="season">季節 <span class="create-form__memo">複数選択可</span></label>
                <div class="season-checkboxes">
                @foreach($seasons as $season)
                <div>
                <input type="checkbox"
                    name="seasons[]"
                    value="{{ $season->id }}"
                    id="season_{{ $season->id }}"
                    {{ in_array($season->id, old('season', $product->seasons->pluck('id')->toArray())) ? 'checked' : '' }}>
                <label for="season_{{ $season->id }}">{{ $season->name }}</label>
                </div>
                @endforeach

        </div>
    @error('season')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

        </div>
    </div>

        {{-- 商品説明 --}}
        <div class="form-group product-detail__description">
            <label for="description">商品説明</label>
            <textarea id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        {{-- ボタン --}}
        <div class="form-buttons">
            <a href="{{ route('products.index') }}">戻る</a>
            <button type="submit">変更を保存</button>
        </div>

    </form>

    <form action="{{ url('/products/' . $product->id . '/delete') }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" style="margin-top:10px;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-delete">🗑 削除</button>
    </form>

</div>

@endsection
