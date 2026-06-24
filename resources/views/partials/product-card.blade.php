<article class="product product-solid">
    <div class="product-image-wrap">
        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
    </div>

    <div class="product-body">
        <div class="category">{{ $product['category'] }}</div>
        <h3>{{ $product['name'] }}</h3>
        <p>{{ $product['description'] }}</p>

        <div class="product-footer">
            <div class="price">
                ${{ number_format($product['price_usd'], 0, '.', ' ') }}
            </div>

            <a class="btn" href="{{ route('payment.checkout', $product['slug']) }}">
                Заказать
            </a>
        </div>
    </div>
</article>