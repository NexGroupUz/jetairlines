@extends('layouts.app')

@section('title', 'Jet Airlines — поставка товаров и онлайн-оплата')

@section('content')

<section class="hero hero-solid">
    <div class="container hero-grid">
        <div>
            <span class="badge">B2B / B2C поставки и онлайн-оплата</span>

            <h1>Jet Airlines — поставка товаров для бизнеса и частных клиентов</h1>

            <p>
                Каталог товаров с возможностью онлайн-оформления заказа и оплаты через
                платежные системы HUMO, UZCard, VISA, MASTERCARD. На сайте представлены направления: сухофрукты,
                строительные материалы и промышленное оборудование.
            </p>

            <div class="hero-actions">
                <a href="#catalog" class="btn">Перейти в каталог</a>
                <a href="{{ route('offer') }}" class="btn btn-secondary">Условия покупки</a>
            </div>

            <div class="hero-stats">
                <div>
                    <strong>3</strong>
                    <span>товарных направления</span>
                </div>
                <div>
                    <strong>24/7</strong>
                    <span>онлайн-оформление</span>
                </div>
                <div>
                    <strong>Доступна</strong>
                    <span>безналичная оплата</span>
                </div>
            </div>
        </div>

        <div class="hero-panel">
            <div class="hero-panel-top">
                <span>Jet Airlines</span>
                <small>Commercial Supply Platform</small>
            </div>

            <div class="hero-panel-card large">
                <div>
                    <span class="panel-label">Категория</span>
                    <h3>Сухофрукты</h3>
                    <p>Товары для торговли, HoReCa и производственных задач.</p>
                </div>
                <div class="panel-number">01</div>
            </div>

            <div class="hero-panel-row">
                <div class="hero-panel-card">
                    <span class="panel-label">Категория</span>
                    <h3>Стройматериалы</h3>
                    <p>Материалы для объектов.</p>
                </div>

                <div class="hero-panel-card dark">
                    <span class="panel-label">Категория</span>
                    <h3>Станки</h3>
                    <p>Промышленное оборудование.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-white">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Направления</span>
                <h2>Три категории товаров на одной платформе</h2>
            </div>
            <p>
                Страница подготовлена как универсальный каталог. После получения
                финального ассортимента можно заменить демонстрационные позиции,
                цены, изображения и условия поставки.
            </p>
        </div>

        <div class="category-grid">
            <div class="category-card">
                <div class="category-icon">01</div>
                <h3>Сухофрукты</h3>
                <p>
                    Отборные позиции для розничных продаж, оптовых поставок,
                    ресторанов, кафе и пищевого производства.
                </p>
            </div>

            <div class="category-card">
                <div class="category-icon">02</div>
                <h3>Стройматериалы</h3>
                <p>
                    Базовые материалы для строительных объектов, ремонта,
                    комплектации и снабжения подрядных организаций.
                </p>
            </div>

            <div class="category-card">
                <div class="category-icon">03</div>
                <h3>Станки</h3>
                <p>
                    Промышленное оборудование для производственных процессов,
                    обработки материалов и технического оснащения.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section" id="catalog">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Каталог</span>
                <h2>Популярные товары</h2>
            </div>
            <p>
                Все товары указаны в демонстрационном формате. Перед запуском нужно
                заменить ассортимент на реальные позиции Jet Airlines.
            </p>
        </div>

        <div class="grid">
            @foreach($products as $product)
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
                                {{ number_format($product['price'], 0, '.', ' ') }} сум
                            </div>

                            <a class="btn" href="{{ route('payment.checkout', $product['slug']) }}">
                                Купить
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section section-white">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Процесс</span>
                <h2>Как проходит оформление заказа</h2>
            </div>
            <p>
                Простая структура покупки: выбор товара, оформление заявки,
                оплата и дальнейшее согласование деталей поставки.
            </p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <span>01</span>
                <h3>Выберите товар</h3>
                <p>
                    Пользователь выбирает нужную позицию из каталога и переходит
                    к оформлению заказа.
                </p>
            </div>

            <div class="step-card">
                <span>02</span>
                <h3>Заполните данные</h3>
                <p>
                    На странице заказа указываются имя, телефон и email для связи
                    по деталям покупки.
                </p>
            </div>

            <div class="step-card">
                <span>03</span>
                <h3>Оплатите онлайн</h3>
                <p>
                    Оплата выполняется банковской картой через платежную систему
                    HUMO, UZCard, VISA, MASTERCARD с подтверждением операции.
                </p>
            </div>

            <div class="step-card">
                <span>04</span>
                <h3>Получите подтверждение</h3>
                <p>
                    После успешной оплаты заказ фиксируется в системе, а клиент
                    получает подтверждение платежа.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="feature-layout">
            <div class="feature-content">
                <span class="badge">Преимущества</span>
                <h2>Сайт подходит для быстрого запуска продаж</h2>
                <p>
                    Решение закрывает базовые задачи: показать ассортимент, принять
                    заявку, провести оплату и сохранить информацию по заказу.
                </p>

                <div class="feature-list">
                    <div>
                        <h3>Единая витрина</h3>
                        <p>Товары разных категорий собраны в одном каталоге.</p>
                    </div>

                    <div>
                        <h3>Онлайн-оплата</h3>
                        <p>Интеграция с HUMO, UZCard, VISA, MASTERCARD позволяет принимать оплату картой.</p>
                    </div>

                    <div>
                        <h3>Гибкая структура</h3>
                        <p>Ассортимент и тексты можно быстро заменить под реальные данные.</p>
                    </div>
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-card-inner">
                    <span>Commercial operations</span>
                    <h3>Каталог, заказ и оплата в одном сценарии</h3>
                    <p>
                        Такой формат можно использовать как стартовую версию сайта,
                        а затем расширить до полноценного личного кабинета,
                        CRM-интеграции или складского учета.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-white">
    <div class="container">
        <div class="payment-block">
            <div>
                <span class="badge">B2B-подход</span>
                <h2>Поставки под задачи бизнеса и частных клиентов</h2>
                <p>
                    Каталог помогает быстро выбрать интересующую категорию и отправить
                    заявку. Для оптовых партий, нестандартных объёмов и специальных
                    условий заказ может дополнительно согласовываться индивидуально.
                </p>
            </div>

            <div class="payment-points">
                <div>
                    <strong>Опт</strong>
                    <span>Поставки для бизнеса</span>
                </div>
                <div>
                    <strong>Розница</strong>
                    <span>Заказы для частных клиентов</span>
                </div>
                <div>
                    <strong>Каталог</strong>
                    <span>Разные категории товаров</span>
                </div>
                <div>
                    <strong>Гибко</strong>
                    <span>Индивидуальные условия</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section cta-section">
    <div class="container">
        <div class="cta-card">
            <div>
                <span class="badge badge-light">Jet Airlines</span>
                <h2>Готовы оформить заказ?</h2>
                <p>
                    Выберите товар из каталога, заполните контактные данные и перейдите
                    к онлайн-оплате через HUMO, UZCard, VISA, MASTERCARD.
                </p>
            </div>

            <a href="#catalog" class="btn btn-light">Смотреть каталог</a>
        </div>
    </div>
</section>

@endsection