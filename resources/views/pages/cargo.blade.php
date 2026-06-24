@extends('layouts.app')

@section('title', 'Авиаперевозка грузов — Jet Airlines')

@section('content')

<section class="section equipment-page">
    <div class="container">
        <div class="equipment-hero">
            <span class="badge">Грузовые авиаперевозки</span>
            <h1>Авиаперевозка грузов и аренда грузового самолёта</h1>
            <p>
                Организация срочной доставки грузов воздушным транспортом:
                коммерческие партии, оборудование, негабаритные, ценные
                и срочные отправления.
            </p>

            <div class="hero-actions">
                <a href="{{ route('payment.checkout', 'air-cargo-transportation') }}" class="btn">
                    Оформить заявку
                </a>
                <a href="{{ route('aviation') }}" class="btn btn-secondary">
                    Все авиауслуги
                </a>
            </div>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <span>01</span>
                <h3>Заявка</h3>
                <p>Клиент указывает маршрут, тип груза, вес, объём и желаемые сроки.</p>
            </div>

            <div class="step-card">
                <span>02</span>
                <h3>Подбор борта</h3>
                <p>Подбирается воздушное судно под габариты, вес и условия перевозки.</p>
            </div>

            <div class="step-card">
                <span>03</span>
                <h3>Согласование</h3>
                <p>Уточняются аэропорты, документы, стоимость, сроки и условия рейса.</p>
            </div>

            <div class="step-card">
                <span>04</span>
                <h3>Перевозка</h3>
                <p>После подтверждения организуется выполнение грузового авиарейса.</p>
            </div>
        </div>
    </div>
</section>

<section class="section section-white">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Типы грузов</span>
                <h2>Какие грузы можно перевозить авиацией</h2>
            </div>
            <p>
                Авиаперевозка подходит, когда важны скорость, сохранность
                и точное соблюдение сроков доставки.
            </p>
        </div>

        <div class="category-grid">
            <div class="category-card">
                <div class="category-icon">01</div>
                <h3>Коммерческие партии</h3>
                <p>Товары для бизнеса, торговые партии, образцы и срочные поставки.</p>
            </div>

            <div class="category-card">
                <div class="category-icon">02</div>
                <h3>Оборудование</h3>
                <p>Станки, производственные узлы, технические детали и комплектующие.</p>
            </div>

            <div class="category-card">
                <div class="category-icon">03</div>
                <h3>Ценные грузы</h3>
                <p>Грузы, требующие сокращения сроков доставки и повышенного контроля.</p>
            </div>

            <div class="category-card">
                <div class="category-icon">04</div>
                <h3>Негабаритные грузы</h3>
                <p>Отправления с нестандартными размерами, весом или условиями погрузки.</p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Воздушные суда</span>
                <h2>Типы самолётов для грузовых авиаперевозок</h2>
            </div>
            <p>
                Ниже представлены ориентировочные характеристики воздушных судов.
                Конкретный борт подбирается индивидуально с учётом маршрута,
                габаритов, веса груза и доступности самолёта.
            </p>
        </div>

        <div class="aircraft-list">
            @foreach($aircraft as $plane)
                <article class="aircraft-card">
                    <div class="aircraft-image">
                        <img src="{{ $plane['image'] }}" alt="{{ $plane['name'] }}">
                    </div>

                    <div class="aircraft-content">
                        <span class="aircraft-label">Характеристика</span>
                        <h3>{{ $plane['name'] }}</h3>

                        <div class="aircraft-specs">
                            <div>
                                <strong>Объём грузового отсека</strong>
                                <span>{{ $plane['cargo_volume'] }}</span>
                            </div>

                            <div>
                                <strong>Габариты грузового отсека</strong>
                                <span>{{ $plane['cargo_dimensions'] }}</span>
                            </div>

                            <div>
                                <strong>Размер люка</strong>
                                <span>{{ $plane['door_size'] }}</span>
                            </div>

                            <div>
                                <strong>Грузоподъёмность</strong>
                                <span>{{ $plane['payload'] }}</span>
                            </div>

                            <div>
                                <strong>Разработка / производство</strong>
                                <span>{{ $plane['manufacturer'] }}</span>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <p class="table-note">
            Характеристики указаны справочно. Фактическая возможность перевозки
            зависит от маршрута, аэропортов, загрузки, типа груза, ограничений
            по безопасности и доступности конкретного воздушного судна.
        </p>
    </div>
</section>

<section class="section section-white">
    <div class="container">
        <div class="payment-block">
            <div>
                <span class="badge">Что нужно для расчёта</span>
                <h2>Данные для подбора грузового самолёта</h2>
                <p>
                    Для расчёта стоимости и подбора борта необходимо указать маршрут,
                    вес, габариты, тип груза, сроки перевозки и особые требования
                    к погрузке или хранению.
                </p>
            </div>

            <div class="payment-points">
                <div>
                    <strong>Маршрут</strong>
                    <span>город отправления и назначения</span>
                </div>
                <div>
                    <strong>Груз</strong>
                    <span>тип, вес и габариты</span>
                </div>
                <div>
                    <strong>Сроки</strong>
                    <span>желаемая дата перевозки</span>
                </div>
                <div>
                    <strong>Условия</strong>
                    <span>погрузка, документы, ограничения</span>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection