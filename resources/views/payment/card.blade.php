@extends('layouts.app')

@section('title', 'Оплата картой — Jet Airlines')

@section('content')

<section class="section">
    <div class="container">
        <div class="content-card">
            <h1>Оплата картой</h1>

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <p><strong>Заказ:</strong> {{ $order->account }}</p>
            <p><strong>Товар:</strong> {{ $order->product_name }}</p>
            <p><strong>Сумма:</strong> {{ number_format($order->amount, 0, '.', ' ') }} сум</p>

            <form class="form" method="POST" action="{{ route('payment.pre_apply', $order) }}">
                @csrf

                <div class="field">
                    <label>Номер карты</label>
                    <input
                        type="text"
                        name="card_number"
                        placeholder="9860090101014364"
                        required
                    >
                </div>

                <div class="field">
                    <label>Срок действия карты</label>
                    <input
                        type="text"
                        name="expiry"
                        placeholder="2802"
                        required
                    >
                    <small>Формат: YYMM. Например, для 02/28 нужно указать 2802.</small>
                </div>

                <button class="btn" type="submit">
                    Получить OTP
                </button>
            </form>

            <h2>Тестовые данные</h2>
            <p>OTP для тестовых карт: <strong>111111</strong></p>

            <ul>
                <li>9860090101014364 — 02/28</li>
                <li>9860090101893213 — 02/28</li>
                <li>9860090101842392 — 02/28</li>
                <li>9860090101469915 — 02/28</li>
                <li>5614688715378807 — 03/29</li>
            </ul>
        </div>
    </div>
</section>

@endsection