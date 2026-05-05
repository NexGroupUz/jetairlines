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
            <p><strong>Сумма:</strong> {{ number_format($order->amount, 0, '.', ' ') }} сум</p>

            @if($order->ofd_url)
                <p>
                    <a class="btn" href="{{ $order->ofd_url }}" target="_blank">
                        Открыть чек OFD
                    </a>
                </p>
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