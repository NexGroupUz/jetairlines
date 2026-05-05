@extends('layouts.app')

@section('title', 'Jet Airlines — товары и поставки')

@section('content')

<section class="hero">
    <div class="container hero-grid">
        <div>
            <span class="badge">Поставка товаров и онлайн-оплата</span>
            <h1>Jet Airlines — каталог товаров для бизнеса и частных клиентов</h1>
            <p>
                На сайте представлены товары из разных направлений: сухофрукты,
                строительные материалы и промышленные станки. Выберите товар,
                оформите заявку и оплатите заказ через платежную систему Atmos.
            </p>
        </div>

        <div class="hero-card">
            <h3>Что можно заказать</h3>
            <ul>
                <li>сухофрукты для торговли и производства;</li>
                <li>строительные материалы для объектов;</li>
                <li>станки и промышленное оборудование;</li>
                <li>онлайн-оплата банковской картой через Atmos.</li>
            </ul>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Каталог</span>
                <h2>Популярные товары</h2>
            </div>
            <p>
                Ассортимент указан для демонстрации структуры сайта.
                Финальные позиции, цены и условия поставки нужно заменить на реальные.
            </p>
        </div>

        <div class="grid">
            @foreach($products as $product)
                <article class="product">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">

                    <div class="product-body">
                        <div class="category">{{ $product['category'] }}</div>
                        <h3>{{ $product['name'] }}</h3>
                        <p>{{ $product['description'] }}</p>

                        <div class="price">
                            {{ number_format($product['price'], 0, '.', ' ') }} сум
                        </div>

                        <a class="btn" href="{{ route('payment.checkout', $product['slug']) }}">
                            Купить
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

@endsection