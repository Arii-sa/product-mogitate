@extends('layout.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css')}}">
@endsection

@section('content')

<div class="create-form">
    <h2 class="create-form__title">商品登録</h2>
    <div class="create-form__inner">
        <form action="/products/register" method="post" enctype="multipart/form-data">
            @csrf

      <div class="create-form__group">
        <label class="create-form__label" for="name">
          商品名<span class="create-form__required">必須</span>
        </label>
        <div class="create-form__name-inputs">
          <input class="create-form__input create-form__name-input" type="text" name="name"
            value="{{ old('name') }}" placeholder="商品名を入力">
        </div>
        <div class="create-form__error-message">
            @error('name')
            {{ $message }}
            @enderror
        </div>
      </div>

      <div class="create-form__group">
        <label class="create-form__label" for="price">
          値段<span class="create-form__required">必須</span>
        </label>
        <div class="create-form__price-inputs">
          <input class="create-form__input create-form__price-input" type="text" name="price"
            value="{{ old('price') }}" placeholder="値段を入力">
        </div>
        <div class="create-form__error-message">
            @error('price')
            {{ $message }}
            @enderror
        </div>
      </div>

      <div class="create-form__group">
        <label class="create-form__label" for="image">
          商品画像<span class="create-form__required">必須</span>
        </label>
        <div class="create-form__image-inputs">
          <input class="create-form__input create-form__image-input" type="file" name="image"
            value="{{ old('image') }}" >
        </div>
        <div class="create-form__error-message">
            @error('image')
            {{ $message }}
            @enderror
        </div>
      </div>

      <div class="create-form__group">
        <label class="create-form__label" for="season">
          季節<span class="create-form__required">必須</span>
          <span class="create-form__memo">複数選択可</span>
        </label>
        <div class="create-form__season-inputs">
            @foreach($seasons as $season)
            <div>
                <input type="checkbox"
                    name="seasons[]"
                    value="{{ $season->id }}"
                    id="season_{{ $season->id }}">
            <label for="season_{{ $season->id }}">{{ $season->name }}</label>
            </div>
            @endforeach
        </div>
        <div class="create-form__error-message">
            @error('seasons')
            {{ $message }}
            @enderror
        </div>
      </div>

      <div class="create-form__group">
        <label class="create-form__label" for="description">
          商品説明<span class="create-form__required">必須</span>
        </label>
        <textarea class="create-form__textarea" name="description" id="" cols="30" rows="5"
          placeholder="商品の説明を入力">{{ old('description') }}</textarea>
        <p class="create-form__error-message">
          @error('description')
          {{ $message }}
          @enderror
        </p>
      </div>

      <div style="margin-top:20px;">

        {{-- 戻るボタン --}}
        <a href="{{ route('products.index') }}">
            <button class="create-form__back" type="button">戻る</button>
        </a>

        {{-- 登録ボタン --}}
        <button class="create-form__btn btn" type="submit">登録</button>

      </div>

    </form>
  </div>
</div>
@endsection