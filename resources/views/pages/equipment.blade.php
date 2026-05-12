@extends('layouts.app')

@section('title', 'Оборудование — Jet Airlines')

@section('content')

<section class="section equipment-page">
    <div class="container">
        <div class="equipment-hero">
            <span class="badge">Оборудование</span>

            <h1>Оборудование и технические материалы</h1>

            <p>
                В этом разделе размещены документы и фотографии оборудования.
                Материалы представлены для предварительного ознакомления.
            </p>
        </div>

        <div class="equipment-layout">
            <div class="equipment-docs">
                <div class="section-head compact">
                    <div>
                        <span class="badge">Документы</span>
                        <h2>Файлы для просмотра</h2>
                    </div>
                    <p>
                        Здесь можно скачать или открыть технические документы,
                        спецификации и дополнительные материалы.
                    </p>
                </div>

                <div class="docs-list">
                    @foreach($documents as $document)
                        <a href="{{ $document['file'] }}" target="_blank" rel="noopener" class="doc-card">
                            <div class="doc-icon">{{ $document['type'] ?? 'FILE' }}</div>

                            <div>
                                <h3>{{ $document['title'] }}</h3>
                                <p>{{ $document['description'] }}</p>
                                <span>Открыть документ →</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="equipment-note">
                <span>Информация</span>
                <h3>Материалы по оборудованию</h3>
                <p>
                    Фотографии и документы можно заменить после получения финальных
                    файлов от Андрея Петровича. Для корректного отображения лучше
                    использовать вертикальные изображения в хорошем качестве.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Сертификаты</span>
                <h2>Сертификационные документы</h2>
            </div>
            <p>
                В этом разделе размещены сертификаты и подтверждающие документы
                по оборудованию.
            </p>
        </div>

        <div class="certificates-grid">
            @foreach($certificates as $certificate)
                <a href="{{ $certificate['file'] }}" target="_blank" rel="noopener" class="certificate-card">
                    <div class="certificate-icon">{{ $certificate['type'] ?? 'PDF' }}</div>

                    <div>
                        <h3>{{ $certificate['title'] }}</h3>
                        <p>{{ $certificate['description'] }}</p>
                        <span>Открыть сертификат →</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section section-white">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="badge">Фотографии</span>
                <h2>Фото оборудования</h2>
            </div>
            <p>
                Вертикальные фотографии оборудования, деталей, узлов или производственных
                элементов.
            </p>
        </div>

        <div class="equipment-gallery">
            @foreach($photos as $photo)
                <a href="{{ $photo }}" target="_blank" rel="noopener" class="equipment-photo">
                    <img src="{{ $photo }}" alt="Фото оборудования">
                </a>
            @endforeach
        </div>
    </div>
</section>

@endsection