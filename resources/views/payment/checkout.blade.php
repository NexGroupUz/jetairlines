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
                ${{ number_format($product['price_usd'], 2, '.', ' ') }}
            </p>

            <p>
                <strong>Курс USD:</strong>
                {{ number_format($usdRate, 2, '.', ' ') }} сум
            </p>

            <p>
                <strong>К оплате:</strong>
                {{ number_format($amountUzs, 0, '.', ' ') }} сум
            </p>

            <form class="form" method="POST" action="{{ route('payment.create') }}" id="checkoutForm">
                @csrf

                <input type="hidden" name="product_slug" value="{{ $product['slug'] }}">

                <div class="field">
                    <label for="customer_name">Ваше имя</label>
                    <input
                        id="customer_name"
                        type="text"
                        name="customer_name"
                        value="{{ old('customer_name') }}"
                        minlength="2"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="field">
                    <label for="phone">Телефон</label>
                    <input
                        id="phone"
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="+998 90 123 45 67"
                        inputmode="tel"
                        autocomplete="tel"
                        maxlength="25"
                        required
                    >
                    <small>Введите номер в международном формате. Например: +998 90 123 45 67.</small>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="name@example.com"
                        autocomplete="email"
                        maxlength="255"
                    >
                </div>

                <div class="field checkbox-field">
                    <label>
                        <input type="checkbox" name="accept_terms" value="1" required>
                        Я ознакомился и принимаю условия
                        <a href="{{ route('offer') }}" target="_blank">Публичной оферты</a>,
                        <a href="{{ route('agreement') }}" target="_blank">Пользовательского соглашения</a>
                        и
                        <a href="{{ route('policy') }}" target="_blank">Политики конфиденциальности</a>.
                    </label>
                </div>

                <button class="btn" type="submit">
                    Оплатить
                </button>
            </form>
        </div>
    </div>
</section>

<script>
    const checkoutForm = document.getElementById('checkoutForm');
    const phoneInput = document.getElementById('phone');

    phoneInput.addEventListener('input', function () {
        let value = this.value;

        value = value.replace(/[^\d+\s().-]/g, '');
        value = value.replace(/(?!^)\+/g, '');

        this.value = value;
    });

    checkoutForm.addEventListener('submit', function () {
        let phone = phoneInput.value.trim();
        phone = phone.replace(/[\s().-]/g, '');
        phoneInput.value = phone;
    });
</script>

@endsection