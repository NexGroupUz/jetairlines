@extends('layouts.app')

@section('title', 'Продажа товаров и оборудования — Jet Airlines')

@section('content')

<section class="section equipment-page">
    <div class="container">
        <div class="equipment-hero">
            <span class="badge">Продажа</span>
            <h1>Товары, станки и промышленное оборудование</h1>
            <p>
                Раздел для коммерческих поставок: станки, оборудование,
                строительные материалы и сопутствующие товарные позиции.
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