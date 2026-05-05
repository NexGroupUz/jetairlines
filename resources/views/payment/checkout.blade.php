@extends('layouts.app')

@section('title', 'Оформление заказа — Jet Airlines')

@section('content')

<section class="section">
    <div class="container">
        <div class="content-card">
            <h1>Оформление заказа</h1>

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <h2>{{ $product['name'] }}</h2>
            <p>{{ $product['description'] }}</p>

            <p>
                <strong>Стоимость:</strong>
                {{ number_format($product['price'], 0, '.', ' ') }} сум
            </p>

            <form class="form" method="POST" action="{{ route('payment.create') }}">
                @csrf

                <input type="hidden" name="product_slug" value="{{ $product['slug'] }}">

                <div class="field">
                    <label>Ваше имя</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required>
                </div>

                <div class="field">
                    <label>Телефон</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+998 XX XXX XX XX" required>
                </div>

                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}">
                </div>

                <button class="btn" type="submit">
                    Перейти к оплате
                </button>
            </form>
        </div>
    </div>
</section>

@endsection