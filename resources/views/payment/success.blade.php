@extends('layouts.app')

@section('title', 'Оплата прошла успешно — Jet Airlines')

@section('content')

<section class="section">
    <div class="container">
        <div class="content-card">
            <div class="alert alert-success">
                Оплата успешно подтверждена.
            </div>

            <h1>Спасибо за заказ</h1>

            <p><strong>Номер заказа:</strong> {{ $order->account }}</p>
            <p><strong>Товар:</strong> {{ $order->product_name }}</p>

            @if($order->amount_usd)
                <p><strong>Стоимость:</strong> ${{ number_format((float) $order->amount_usd, 2, '.', ' ') }}</p>
            @endif

            @if($order->usd_rate)
                <p><strong>Курс USD:</strong> {{ number_format((float) $order->usd_rate, 2, '.', ' ') }} сум</p>
            @endif

            <p><strong>Оплачено:</strong> {{ number_format($order->amount, 0, '.', ' ') }} сум</p>

            @if($order->paid_at)
                <p><strong>Дата оплаты:</strong> {{ $order->paid_at->format('d.m.Y H:i') }}</p>
            @endif

            <p>
                <a class="btn btn-secondary" href="{{ route('home') }}">
                    Вернуться на главную
                </a>
            </p>
        </div>
    </div>
</section>

@endsection