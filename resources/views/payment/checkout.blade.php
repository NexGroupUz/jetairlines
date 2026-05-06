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
                    <small>Email необязателен, но нужен для отправки информации по заказу.</small>
                </div>

                <button class="btn" type="submit">
                    Перейти к оплате
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

        // Разрешаем только цифры, +, пробел, дефис, скобки
        value = value.replace(/[^\d+\s().-]/g, '');

        // + можно использовать только в начале
        value = value.replace(/(?!^)\+/g, '');

        this.value = value;
    });

    checkoutForm.addEventListener('submit', function () {
        let phone = phoneInput.value.trim();

        // Убираем пробелы, скобки и дефисы перед отправкой
        phone = phone.replace(/[\s().-]/g, '');

        phoneInput.value = phone;
    });
</script>

@endsection