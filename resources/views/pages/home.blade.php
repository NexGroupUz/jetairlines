@extends('layouts.app')

@section('title', 'Jet Airlines — авиационные услуги и поставка оборудования')

@section('content')

<section class="hero hero-solid">
    <div class="container hero-grid">
        <div>
            <span class="badge">Авиационные услуги / Поставка оборудования</span>

            <h1>Jet Airlines — авиационные перевозки, фрахт и поставка оборудования</h1>

            <p>
                Организуем авиаперевозки грузов, аренду и фрахт воздушных судов,
                включая бизнес-джеты и грузовые самолёты. Также на сайте представлены
                товары и оборудование для коммерческих поставок.
            </p>

            <div class="hero-actions">
                <a href="{{ route('aviation') }}" class="btn">Авиационные услуги</a>
                <a href="{{ route('sales') }}" class="btn btn-secondary">Продажа товаров</a>
            </div>

            <div class="hero-stats">
                <div>
                    <strong>2</strong>
                    <span>основных направления</span>
                </div>
                <div>
                    <strong>USD</strong>
                    <span>цены на сайте</span>
                </div>
                <div>
                    <strong>UZS</strong>
                    <span>оплата по курсу ЦБ</span>
                </div>
            </div>
        </div>

        <div class="hero-panel">
            <div class="hero-panel-top">
                <span>Jet Airlines</span>
                <small>Air Cargo & Commercial Supply</small>
            </div>

            <div class="hero-panel-card large">
                <div>
                    <span class="panel-label">Направление</span>
                    <h3>Авиационные услуги</h3>
                    <p>Грузовые авиаперевозки, аренда бизнес-джетов и фрахт воздушных судов.</p>
                </div>
                <div class="panel-number">01</div>
            </div>

            <div class="hero-panel-row">
                <div class="hero-panel-card">
                    <span class="panel-label">Продажа</span>
                    <h3>Оборудование</h3>
                    <p>Станки, техника и промышленные товары.</p>
                </div>

                <div class="hero-panel-card dark">
                    <span class="panel-label">Оплата</span>
                    <h3>USD → UZS</h3>
                    <p>Цена указывается в долларах, оплата проводится в сумах.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-white">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Структура</span>
                <h2>Два направления на одном сайте</h2>
            </div>
            <p>
                Сайт разделён на авиационные услуги и коммерческие поставки,
                чтобы клиенту было проще выбрать нужный раздел.
            </p>
        </div>

        <div class="business-groups">
            <a href="{{ route('aviation') }}" class="business-group-card aviation-card">
                <span>01</span>
                <h3>Авиационные услуги</h3>
                <p>
                    Авиаперевозки грузов, аренда самолётов, фрахт бизнес-джетов
                    и грузовых воздушных судов.
                </p>
                <strong>Перейти к услугам →</strong>
            </a>

            <a href="{{ route('sales') }}" class="business-group-card sales-card">
                <span>02</span>
                <h3>Продажа товаров и оборудования</h3>
                <p>
                    Станки, промышленное оборудование, строительные материалы
                    и сопутствующие товарные позиции.
                </p>
                <strong>Перейти к товарам →</strong>
            </a>
        </div>
    </div>
</section>

<section class="section" id="catalog">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Авиация</span>
                <h2>Авиационные услуги</h2>
            </div>
            <p>
                Услуги по аренде и фрахту воздушных судов, а также организация
                грузовых авиаперевозок.
            </p>
        </div>

        <div class="grid">
            @foreach($aviationProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<section class="section section-white">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Продажа</span>
                <h2>Товары и оборудование</h2>
            </div>
            <p>
                Отдельное направление для продажи станков, оборудования,
                строительных материалов и коммерческих товарных позиций.
            </p>
        </div>

        <div class="grid">
            @foreach($salesProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<section class="section section-white">
    <div class="container">
        <div class="payment-block">
            <div>
                <span class="badge">Валюта</span>
                <h2>Цены указаны в USD, оплата проводится в UZS</h2>
                <p>
                    Для удобства клиентов стоимость на сайте отображается в долларах США.
                    При переходе к оплате сумма автоматически пересчитывается в сумы
                    по актуальному курсу Центрального банка Республики Узбекистан.
                </p>
            </div>

            <div class="payment-points">
                <div>
                    <strong>USD</strong>
                    <span>цена на сайте</span>
                </div>
                <div>
                    <strong>CBU</strong>
                    <span>курс ЦБ Узбекистана</span>
                </div>
                <div>
                    <strong>UZS</strong>
                    <span>сумма к оплате</span>
                </div>
                <div>
                    <strong>OCTO</strong>
                    <span>онлайн-оплата картой</span>
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
                <h2>Выберите нужное направление</h2>
                <p>
                    Перейдите в раздел авиационных услуг для аренды и фрахта воздушных судов
                    или откройте каталог товаров и оборудования.
                </p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('aviation') }}" class="btn btn-light">Авиационные услуги</a>
                <a href="{{ route('sales') }}" class="btn btn-secondary">Продажа товаров</a>
            </div>
        </div>
    </div>
</section>

@endsection