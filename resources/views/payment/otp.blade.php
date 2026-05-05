@extends('layouts.app')

@section('title', 'Подтверждение OTP — Jet Airlines')

@section('content')

<section class="section">
    <div class="container">
        <div class="content-card">
            <h1>Подтверждение оплаты</h1>

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <p><strong>Заказ:</strong> {{ $order->account }}</p>
            <p><strong>Сумма:</strong> {{ number_format($order->amount, 0, '.', ' ') }} сум</p>

            <form class="form" method="POST" action="{{ route('payment.apply', $order) }}">
                @csrf

                <div class="field">
                    <label>OTP-код</label>
                    <input type="text" name="otp" placeholder="111111" required>
                </div>

                <button class="btn" type="submit">
                    Подтвердить оплату
                </button>
            </form>
        </div>
    </div>
</section>

@endsection