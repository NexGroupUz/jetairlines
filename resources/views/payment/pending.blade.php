@extends('layouts.app')

@section('title', 'Платёж обрабатывается — Jet Airlines')

@section('content')

<section class="section">
    <div class="container">
        <div class="content-card">
            <h1>Платёж обрабатывается</h1>

            <p>
                Мы ожидаем подтверждение платежа от платёжной системы.
                Обычно это занимает несколько секунд.
            </p>

            <p><strong>Номер заказа:</strong> {{ $order->account }}</p>
            <p><strong>Товар:</strong> {{ $order->product_name }}</p>

            @if($order->amount_usd)
                <p><strong>Стоимость:</strong> ${{ number_format((float) $order->amount_usd, 2, '.', ' ') }}</p>
            @endif

            <p><strong>К оплате:</strong> {{ number_format($order->amount, 0, '.', ' ') }} сум</p>

            <p>
                <a class="btn" href="{{ route('payment.status', $order) }}">
                    Проверить статус
                </a>
            </p>

            @if($order->octo_pay_url)
                <p>
                    <a class="btn btn-secondary" href="{{ $order->octo_pay_url }}">
                        Вернуться к оплате
                    </a>
                </p>
            @endif
        </div>
    </div>
</section>

@endsection