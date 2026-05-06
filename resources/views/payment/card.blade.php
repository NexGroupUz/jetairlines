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

            <form class="form" method="POST" action="{{ route('payment.pre_apply', $order) }}" id="cardPaymentForm">
                @csrf

                <div class="field">
                    <label for="card_number">Номер карты</label>
                    <input
                        id="card_number"
                        type="text"
                        name="card_number"
                        inputmode="numeric"
                        autocomplete="cc-number"
                        placeholder="9860 0901 0101 4364"
                        maxlength="19"
                        pattern="^\d{4}\s\d{4}\s\d{4}\s\d{4}$"
                        value="{{ old('card_number') }}"
                        required
                    >
                    <small>Введите 16 цифр номера карты.</small>
                </div>

                <div class="field">
                    <label for="expiry">Срок действия карты</label>
                    <input
                        id="expiry"
                        type="text"
                        name="expiry"
                        inputmode="numeric"
                        autocomplete="cc-exp"
                        placeholder="02/28"
                        maxlength="5"
                        pattern="^(0[1-9]|1[0-2])\/\d{2}$"
                        value="{{ old('expiry') }}"
                        required
                    >
                    <small>Формат: MM/YY. Например: 02/28.</small>
                </div>

                <button class="btn" type="submit">
                    Получить OTP
                </button>
            </form>
        </div>
    </div>
</section>

<script>
    const cardInput = document.getElementById('card_number');
    const expiryInput = document.getElementById('expiry');
    const form = document.getElementById('cardPaymentForm');

    cardInput.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, '').slice(0, 16);

        this.value = value.replace(/(.{4})/g, '$1 ').trim();
    });

    expiryInput.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, '').slice(0, 4);

        if (value.length >= 3) {
            value = value.slice(0, 2) + '/' + value.slice(2);
        }

        this.value = value;
    });

    form.addEventListener('submit', function () {
        cardInput.value = cardInput.value.replace(/\D/g, '');

        const expiryDigits = expiryInput.value.replace(/\D/g, '');

        if (expiryDigits.length === 4) {
            const month = expiryDigits.slice(0, 2);
            const year = expiryDigits.slice(2, 4);

            // Atmos ждёт YYMM: 02/28 -> 2802
            expiryInput.value = year + month;
        }
    });
</script>

@endsection