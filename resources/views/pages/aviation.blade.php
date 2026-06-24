@extends('layouts.app')

@section('title', 'Авиационные услуги — Jet Airlines')

@section('content')

<section class="section equipment-page">
    <div class="container">
        <div class="equipment-hero">
            <span class="badge">Авиационные услуги</span>
            <h1>Авиаперевозки, аренда и фрахт воздушных судов</h1>
            <p>
                Организация грузовых авиаперевозок, аренда бизнес-джетов,
                фрахт грузовых самолётов и подбор воздушного судна под задачу клиента.
            </p>

            <div class="hero-actions">
                <a href="{{ route('cargo') }}" class="btn">Подробнее о грузоперевозках</a>
                <a href="#services" class="btn btn-secondary">Выбрать услугу</a>
            </div>
        </div>

        <div class="feature-layout">
            <div class="feature-content">
                <span class="badge">Фрахт воздушных судов</span>
                <h2>Подбор самолёта под маршрут, груз и сроки</h2>
                <p>
                    Авиационные услуги могут использоваться для срочных коммерческих
                    отправлений, перевозки оборудования, деловых перелётов,
                    чартерных рейсов и нестандартных логистических задач.
                </p>

                <div class="feature-list">
                    <div>
                        <h3>Грузовые авиаперевозки</h3>
                        <p>Для срочных, ценных, коммерческих и нестандартных грузов.</p>
                    </div>

                    <div>
                        <h3>Бизнес-джеты</h3>
                        <p>Частные и корпоративные перелёты по индивидуальному маршруту.</p>
                    </div>

                    <div>
                        <h3>Грузовые самолёты</h3>
                        <p>Фрахт воздушных судов под объёмные и тяжёлые отправления.</p>
                    </div>
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-card-inner">
                    <span>Jet Airlines</span>
                    <h3>Аренда и фрахт воздушных судов</h3>
                    <p>
                        Раздел ориентирован на клиентов, которым требуется быстрое
                        авиационное решение: от бизнес-перелёта до перевозки груза.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-white" id="services">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Услуги</span>
                <h2>Доступные авиационные услуги</h2>
            </div>
            <p>
                Стоимость указана ориентировочно в USD. Финальная цена зависит
                от маршрута, типа воздушного судна, груза и дополнительных условий.
            </p>
        </div>

        <div class="grid">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

@endsection