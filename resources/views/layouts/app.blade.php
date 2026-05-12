<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Jet Airlines')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --dark: #0d1726;
            --blue: #1f4fd8;
            --text: #1e293b;
            --muted: #64748b;
            --bg: #f8fafc;
            --card: #ffffff;
            --border: #e2e8f0;
            --green: #16a34a;
            --red: #dc2626;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
        }

        .header {
            background: #ffffffcc;
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .header-inner {
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .logo {
            font-weight: 800;
            letter-spacing: -0.04em;
            font-size: 24px;
            color: var(--dark);
        }

        .nav {
            display: flex;
            gap: 18px;
            font-size: 14px;
            color: var(--muted);
        }

        .nav a:hover {
            color: var(--blue);
        }

        .hero {
            padding: 84px 0;
            background:
                radial-gradient(circle at 80% 20%, #dbeafe 0, transparent 35%),
                linear-gradient(135deg, #ffffff 0%, #eef4ff 100%);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 48px;
            align-items: center;
        }

        .badge {
            display: inline-flex;
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: white;
            color: var(--blue);
            font-size: 14px;
            font-weight: 700;
        }

        .hero h1 {
            font-size: clamp(38px, 5vw, 72px);
            line-height: 0.95;
            margin: 24px 0;
            color: var(--dark);
            letter-spacing: -0.06em;
        }

        .hero p {
            font-size: 18px;
            color: var(--muted);
            max-width: 650px;
        }

        .hero-card {
            background: var(--dark);
            color: white;
            padding: 32px;
            border-radius: 28px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, .18);
        }

        .hero-card h3 {
            margin-top: 0;
            font-size: 24px;
        }

        .hero-card ul {
            padding-left: 18px;
            color: #cbd5e1;
        }

        .section {
            padding: 72px 0;
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 24px;
            margin-bottom: 32px;
        }

        .section-head h2 {
            margin: 0;
            font-size: 38px;
            letter-spacing: -0.04em;
            color: var(--dark);
        }

        .section-head p {
            max-width: 520px;
            color: var(--muted);
            margin: 0;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
        }

        .product {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 24px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }

        .product img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }

        .product-body {
            padding: 22px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .category {
            font-size: 13px;
            color: var(--blue);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .product h3 {
            margin: 0 0 8px;
            font-size: 22px;
            color: var(--dark);
        }

        .product p {
            margin: 0 0 18px;
            color: var(--muted);
        }

        .price {
            font-size: 22px;
            font-weight: 800;
            color: var(--dark);
            margin-top: auto;
            margin-bottom: 16px;
        }

        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 46px;
            padding: 12px 18px;
            border-radius: 14px;
            background: var(--blue);
            color: white;
            border: 0;
            cursor: pointer;
            font-weight: 700;
            font-size: 15px;
        }

        .btn:hover {
            opacity: .92;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: var(--dark);
        }

        .content-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 32px;
        }

        .content-card h1 {
            margin-top: 0;
            font-size: 42px;
            letter-spacing: -0.04em;
            color: var(--dark);
        }

        .content-card h2 {
            margin-top: 34px;
            color: var(--dark);
        }

        .content-card p,
        .content-card li {
            color: var(--muted);
        }

        .form {
            display: grid;
            gap: 16px;
        }

        .field label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .field input {
            width: 100%;
            min-height: 48px;
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 0 14px;
            font-size: 16px;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 14px;
            margin-bottom: 18px;
        }

        .alert-error {
            background: #fef2f2;
            color: var(--red);
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #f0fdf4;
            color: var(--green);
            border: 1px solid #bbf7d0;
        }

        .footer {
            border-top: 1px solid var(--border);
            background: white;
            padding: 28px 0;
            color: var(--muted);
            font-size: 14px;
        }

        .footer-inner {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        @media (max-width: 900px) {
            .hero-grid,
            .grid {
                grid-template-columns: 1fr;
            }

            .section-head {
                display: block;
            }

            .nav {
                display: none;
            }
        }

        .hero-solid {
    position: relative;
    overflow: hidden;
    background:
        radial-gradient(circle at 85% 15%, rgba(31, 79, 216, .18), transparent 32%),
        radial-gradient(circle at 10% 80%, rgba(15, 23, 42, .10), transparent 35%),
        linear-gradient(135deg, #f8fafc 0%, #eef4ff 48%, #ffffff 100%);
}

.hero-solid::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(15, 23, 42, .04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(15, 23, 42, .04) 1px, transparent 1px);
    background-size: 48px 48px;
    mask-image: linear-gradient(to bottom, black, transparent 85%);
    pointer-events: none;
}

.hero-solid .container {
    position: relative;
    z-index: 1;
}

.hero-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 30px;
}

.hero-stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-top: 34px;
}

.hero-stats div {
    background: rgba(255, 255, 255, .72);
    border: 1px solid rgba(226, 232, 240, .9);
    border-radius: 18px;
    padding: 18px;
    backdrop-filter: blur(12px);
}

.hero-stats strong {
    display: block;
    font-size: 24px;
    color: var(--dark);
    margin-bottom: 4px;
}

.hero-stats span {
    display: block;
    font-size: 13px;
    color: var(--muted);
}

.hero-panel {
    background: rgba(255, 255, 255, .72);
    border: 1px solid rgba(226, 232, 240, .9);
    border-radius: 32px;
    padding: 22px;
    box-shadow: 0 30px 90px rgba(15, 23, 42, .14);
    backdrop-filter: blur(18px);
}

.hero-panel-top {
    display: flex;
    justify-content: space-between;
    gap: 14px;
    align-items: center;
    margin-bottom: 16px;
    color: var(--dark);
    font-weight: 800;
}

.hero-panel-top small {
    color: var(--muted);
    font-weight: 600;
}

.hero-panel-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.hero-panel-card {
    border-radius: 24px;
    padding: 22px;
    background: white;
    border: 1px solid var(--border);
}

.hero-panel-card.large {
    min-height: 220px;
    margin-bottom: 14px;
    background:
        linear-gradient(135deg, rgba(31, 79, 216, .10), transparent),
        white;
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.hero-panel-card.dark {
    background: var(--dark);
    color: white;
}

.hero-panel-card h3 {
    margin: 8px 0;
    font-size: 22px;
}

.hero-panel-card p {
    margin: 0;
    color: var(--muted);
    font-size: 14px;
}

.hero-panel-card.dark p {
    color: #cbd5e1;
}

.panel-label {
    color: var(--blue);
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.hero-panel-card.dark .panel-label {
    color: #93c5fd;
}

.panel-number {
    font-size: 56px;
    line-height: 1;
    color: rgba(31, 79, 216, .20);
    font-weight: 900;
}

.section-white {
    background: white;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 22px;
}

.category-card {
    background:
        linear-gradient(135deg, rgba(31, 79, 216, .06), transparent 60%),
        #ffffff;
    border: 1px solid var(--border);
    border-radius: 26px;
    padding: 28px;
    min-height: 260px;
}

.category-icon {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    background: var(--dark);
    color: white;
    display: grid;
    place-items: center;
    font-weight: 900;
    margin-bottom: 28px;
}

.category-card h3 {
    font-size: 24px;
    margin: 0 0 12px;
    color: var(--dark);
}

.category-card p {
    color: var(--muted);
    margin: 0;
}

.product-solid {
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
}

.product-solid:hover {
    transform: translateY(-4px);
    box-shadow: 0 24px 60px rgba(15, 23, 42, .10);
    border-color: rgba(31, 79, 216, .24);
}

.product-image-wrap {
    background: #eef2ff;
    padding: 10px;
}

.product-image-wrap img {
    border-radius: 18px;
}

.product-footer {
    margin-top: auto;
}

.steps-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
}

.step-card {
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 24px;
}

.step-card span {
    display: inline-flex;
    color: var(--blue);
    font-weight: 900;
    margin-bottom: 24px;
}

.step-card h3 {
    margin: 0 0 10px;
    color: var(--dark);
    font-size: 20px;
}

.step-card p {
    margin: 0;
    color: var(--muted);
    font-size: 14px;
}

.feature-layout {
    display: grid;
    grid-template-columns: 1fr .85fr;
    gap: 28px;
    align-items: stretch;
}

.feature-content {
    background: white;
    border: 1px solid var(--border);
    border-radius: 30px;
    padding: 34px;
}

.feature-content h2 {
    font-size: 38px;
    line-height: 1.05;
    letter-spacing: -0.04em;
    margin: 18px 0;
    color: var(--dark);
}

.feature-content > p {
    color: var(--muted);
    max-width: 680px;
}

.feature-list {
    display: grid;
    gap: 14px;
    margin-top: 28px;
}

.feature-list div {
    padding: 18px;
    border-radius: 20px;
    background: #f8fafc;
    border: 1px solid var(--border);
}

.feature-list h3 {
    margin: 0 0 6px;
    color: var(--dark);
}

.feature-list p {
    margin: 0;
    color: var(--muted);
}

.feature-card {
    border-radius: 30px;
    padding: 1px;
    background:
        radial-gradient(circle at 20% 20%, rgba(96, 165, 250, .55), transparent 30%),
        linear-gradient(135deg, #0d1726, #1f4fd8);
    min-height: 100%;
}

.feature-card-inner {
    height: 100%;
    border-radius: 30px;
    padding: 34px;
    color: white;
    background:
        linear-gradient(135deg, rgba(15, 23, 42, .92), rgba(15, 23, 42, .72));
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

.feature-card-inner span {
    color: #93c5fd;
    font-size: 13px;
    text-transform: uppercase;
    font-weight: 800;
    letter-spacing: .08em;
}

.feature-card-inner h3 {
    font-size: 30px;
    line-height: 1.1;
    letter-spacing: -0.04em;
    margin: 16px 0;
}

.feature-card-inner p {
    color: #cbd5e1;
    margin: 0;
}

.payment-block {
    display: grid;
    grid-template-columns: .9fr 1.1fr;
    gap: 32px;
    align-items: center;
    background:
        linear-gradient(135deg, rgba(31, 79, 216, .08), transparent),
        #f8fafc;
    border: 1px solid var(--border);
    border-radius: 30px;
    padding: 34px;
}

.payment-block h2 {
    font-size: 36px;
    line-height: 1.05;
    letter-spacing: -0.04em;
    color: var(--dark);
    margin: 18px 0;
}

.payment-block p {
    color: var(--muted);
}

.payment-points {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}

.payment-points div {
    background: white;
    border: 1px solid var(--border);
    border-radius: 22px;
    padding: 22px;
}

.payment-points strong {
    display: block;
    color: var(--blue);
    font-size: 22px;
    margin-bottom: 12px;
}

.payment-points span {
    color: var(--dark);
    font-weight: 700;
}

.cta-section {
    padding-top: 30px;
}

.cta-card {
    background:
        radial-gradient(circle at 85% 20%, rgba(96, 165, 250, .35), transparent 30%),
        linear-gradient(135deg, #0d1726, #172554);
    color: white;
    border-radius: 34px;
    padding: 42px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 28px;
}

.cta-card h2 {
    margin: 18px 0 10px;
    font-size: 38px;
    line-height: 1.05;
    letter-spacing: -0.04em;
}

.cta-card p {
    color: #cbd5e1;
    max-width: 650px;
    margin: 0;
}

.badge-light {
    background: rgba(255, 255, 255, .10);
    color: white;
    border-color: rgba(255, 255, 255, .20);
}

.btn-light {
    background: white;
    color: var(--dark);
    white-space: nowrap;
}

@media (max-width: 1000px) {
    .hero-stats,
    .category-grid,
    .steps-grid,
    .feature-layout,
    .payment-block {
        grid-template-columns: 1fr;
    }

    .payment-points {
        grid-template-columns: 1fr;
    }

    .cta-card {
        display: block;
    }

    .cta-card .btn {
        margin-top: 24px;
    }
}

@media (max-width: 640px) {
    .hero-panel-row {
        grid-template-columns: 1fr;
    }

    .hero-stats {
        gap: 10px;
    }

    .hero-stats div,
    .category-card,
    .feature-content,
    .payment-block,
    .cta-card {
        padding: 22px;
    }

    .steps-grid {
        gap: 12px;
    }
}


.equipment-page {
    background:
        radial-gradient(circle at 90% 10%, rgba(31, 79, 216, .12), transparent 32%),
        linear-gradient(135deg, #f8fafc 0%, #eef4ff 100%);
}

.equipment-hero {
    max-width: 820px;
    margin-bottom: 42px;
}

.equipment-hero h1 {
    margin: 20px 0;
    font-size: clamp(38px, 5vw, 64px);
    line-height: 1;
    letter-spacing: -0.06em;
    color: var(--dark);
}

.equipment-hero p {
    font-size: 18px;
    color: var(--muted);
    max-width: 720px;
}

.equipment-layout {
    display: grid;
    grid-template-columns: 1fr .45fr;
    gap: 24px;
    align-items: start;
}

.section-head.compact {
    display: block;
    margin-bottom: 24px;
}

.section-head.compact h2 {
    margin-top: 14px;
}

.equipment-docs {
    background: white;
    border: 1px solid var(--border);
    border-radius: 30px;
    padding: 30px;
}

.docs-list {
    display: grid;
    gap: 14px;
}

.doc-card {
    display: grid;
    grid-template-columns: 72px 1fr;
    gap: 18px;
    align-items: center;
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 22px;
    padding: 18px;
    transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
}

.doc-card:hover {
    transform: translateY(-3px);
    border-color: rgba(31, 79, 216, .28);
    box-shadow: 0 18px 46px rgba(15, 23, 42, .08);
}

.doc-icon {
    width: 72px;
    height: 72px;
    border-radius: 18px;
    background: var(--dark);
    color: white;
    display: grid;
    place-items: center;
    font-weight: 900;
    letter-spacing: .04em;
}

.doc-card h3 {
    margin: 0 0 6px;
    color: var(--dark);
    font-size: 20px;
}

.doc-card p {
    margin: 0 0 8px;
    color: var(--muted);
}

.doc-card span {
    color: var(--blue);
    font-weight: 700;
    font-size: 14px;
}

.equipment-note {
    background:
        radial-gradient(circle at 20% 20%, rgba(96, 165, 250, .28), transparent 36%),
        var(--dark);
    color: white;
    border-radius: 30px;
    padding: 30px;
    min-height: auto;
}

.equipment-note span {
    display: inline-flex;
    margin-bottom: 18px;
    color: #93c5fd;
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.equipment-note h3 {
    margin: 0 0 14px;
    font-size: 28px;
    line-height: 1.1;
    letter-spacing: -0.04em;
}

.equipment-note p {
    margin: 0;
    color: #cbd5e1;
}

.equipment-gallery {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 22px;
}

.equipment-photo {
    display: block;
    aspect-ratio: 3 / 4;
    overflow: hidden;
    border-radius: 28px;
    background: #e2e8f0;
    border: 1px solid var(--border);
    box-shadow: 0 18px 46px rgba(15, 23, 42, .08);
    transition: transform .2s ease, box-shadow .2s ease;
}

.equipment-photo:hover {
    transform: translateY(-4px);
    box-shadow: 0 26px 70px rgba(15, 23, 42, .14);
}

.equipment-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

@media (max-width: 1000px) {
    .equipment-layout {
        grid-template-columns: 1fr;
    }

    .equipment-gallery {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 640px) {
    .equipment-docs,
    .equipment-note {
        padding: 22px;
    }

    .doc-card {
        grid-template-columns: 1fr;
    }

    .doc-icon {
        width: 64px;
        height: 64px;
    }

    .equipment-gallery {
        grid-template-columns: 1fr;
    }
}
    </style>
</head>
<body>

<header class="header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="logo">Jet Airlines</a>

        <nav class="nav">
            <a href="{{ route('home') }}">Главная</a>
            <a href="{{ route('equipment') }}">Оборудование</a>
            <a href="{{ route('offer') }}">Оферта</a>
            <a href="{{ route('agreement') }}">Пользовательское соглашение</a>
            <a href="{{ route('policy') }}">Политика конфиденциальности</a>
        </nav>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="footer">
    <div class="container footer-inner">
        <div>© {{ date('Y') }} Jet Airlines. Все права защищены.</div>
        <div>
            <a href="{{ route('offer') }}">Оферта</a> ·
            <a href="{{ route('policy') }}">Политика</a>
        </div>
    </div>
</footer>

</body>
</html>