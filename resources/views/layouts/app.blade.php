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
    </style>
</head>
<body>

<header class="header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="logo">Jet Airlines</a>

        <nav class="nav">
            <a href="{{ route('home') }}">Главная</a>
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