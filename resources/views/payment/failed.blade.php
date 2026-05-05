@extends('layouts.app')

@section('title', 'Ошибка оплаты — Jet Airlines')

@section('content')

<section class="section">
    <div class="container">
        <div class="content-card">
            <div class="alert alert-error">
                Оплату не удалось завершить.
            </div>

            <h1>Ошибка оплаты</h1>

            <p><strong>Номер заказа:</strong> {{ $order->account }}</p>
            <p><strong>Статус:</strong> {{ $order->status }}</p>

            @if($error)
                <p><strong>Техническая ошибка:</strong> {{ $error }}</p>
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