<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profex — финансовый учёт для ИП Казахстана</title>
    <meta name="description" content="Мобильное приложение для управленческого и финансового учёта индивидуальных предпринимателей Республики Казахстан">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #0A0E17;
            color: #F0F4F8;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }

        /* Header */
        .header {
            padding: 20px 0;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo img {
            width: 40px;
            height: 40px;
            border-radius: 10px;
        }
        .logo span {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .nav-links {
            display: flex;
            gap: 32px;
        }
        .nav-links a {
            color: #A8B8CC;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: #F0F4F8; }

        /* Hero */
        .hero {
            padding: 100px 0 80px;
            text-align: center;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(0,230,138,0.1);
            color: #00E68A;
            font-size: 14px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            margin-bottom: 28px;
            border: 1px solid rgba(0,230,138,0.2);
        }
        .hero h1 {
            font-size: clamp(36px, 5vw, 56px);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
        }
        .hero h1 .accent { color: #00E68A; }
        .hero p {
            font-size: 18px;
            color: #A8B8CC;
            max-width: 560px;
            margin: 0 auto 40px;
        }
        .store-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .store-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #1A2236;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 14px 28px;
            font-size: 15px;
            font-weight: 600;
            color: #F0F4F8;
            transition: background 0.2s, border-color 0.2s;
        }
        .store-btn:hover {
            background: #1F2A42;
            border-color: rgba(255,255,255,0.15);
        }
        .store-btn svg { width: 22px; height: 22px; fill: currentColor; }

        /* Features */
        .features {
            padding: 80px 0;
        }
        .features-title {
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: #00E68A;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 16px;
        }
        .features-heading {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 56px;
            letter-spacing: -0.5px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }
        .feature-card {
            background: #111827;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 20px;
            padding: 32px;
            transition: border-color 0.2s;
        }
        .feature-card:hover {
            border-color: rgba(0,230,138,0.2);
        }
        .feature-icon {
            width: 48px;
            height: 48px;
            background: rgba(0,230,138,0.1);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 22px;
        }
        .feature-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .feature-card p {
            font-size: 15px;
            color: #A8B8CC;
            line-height: 1.6;
        }

        /* Contact */
        .contact {
            padding: 80px 0 100px;
        }
        .contact-wrapper {
            background: #111827;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 24px;
            padding: 56px;
            max-width: 680px;
            margin: 0 auto;
        }
        .contact-wrapper h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            text-align: center;
        }
        .contact-subtitle {
            text-align: center;
            color: #A8B8CC;
            font-size: 16px;
            margin-bottom: 36px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #A8B8CC;
            margin-bottom: 8px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            background: #1A2236;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 15px;
            color: #F0F4F8;
            font-family: inherit;
            transition: border-color 0.2s;
            outline: none;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #00E68A;
        }
        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #7A8DA4;
        }
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        .form-error {
            color: #FF4D6A;
            font-size: 13px;
            margin-top: 6px;
        }
        .submit-btn {
            display: block;
            width: 100%;
            background: #00E68A;
            color: #0A0E17;
            border: none;
            border-radius: 14px;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 28px;
        }
        .submit-btn:hover { background: #00CC7A; }
        .success-message {
            background: rgba(0,230,138,0.1);
            border: 1px solid rgba(0,230,138,0.3);
            border-radius: 12px;
            padding: 16px 20px;
            color: #00E68A;
            font-size: 15px;
            font-weight: 500;
            text-align: center;
            margin-bottom: 24px;
        }

        /* Footer */
        .footer {
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: 32px 0;
            text-align: center;
        }
        .footer-links {
            display: flex;
            gap: 24px;
            justify-content: center;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        .footer-links a {
            color: #A8B8CC;
            font-size: 14px;
            transition: color 0.2s;
        }
        .footer-links a:hover { color: #00E68A; }
        .footer-copy {
            color: #7A8DA4;
            font-size: 13px;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .hero { padding: 60px 0 48px; }
            .contact-wrapper { padding: 32px 20px; }
            .nav-links { display: none; }
            .features-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="header">
        <div class="container header-inner">
            <div class="logo">
                <img src="/legal/../favicon.ico" alt="Profex" onerror="this.style.display='none'">
                <span>Profex</span>
            </div>
            <nav class="nav-links">
                <a href="#features">Возможности</a>
                <a href="#contact">Поддержка</a>
                <a href="/legal/privacy.html">Конфиденциальность</a>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section class="hero">
        <div class="container">
            <div class="hero-badge">iOS + Android</div>
            <h1>Финансовый учёт<br>для <span class="accent">ИП Казахстана</span></h1>
            <p>Управленческий учёт без бухгалтера. Выручка, расходы, налоги, зарплаты и отчёты — всё в одном приложении</p>
            <div class="store-buttons">
                <a href="#" class="store-btn">
                    <svg viewBox="0 0 24 24"><path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/></svg>
                    App Store
                </a>
                <a href="#" class="store-btn">
                    <svg viewBox="0 0 24 24"><path d="M3.18 23.79c-.36-.17-.59-.52-.59-.94V1.15c0-.42.23-.77.59-.94l11.07 11.29L3.18 23.79zm.82-23.33L15.6 10.7l-2.65 2.7L4 .46zm16.16 10.3l-3.22-1.85-2.97 3.03 2.97 3.03 3.22-1.85c.56-.32.56-1.04 0-1.36zM4 23.54l11.6-10.24-2.65-2.7L4 23.54z"/></svg>
                    Google Play
                </a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features" id="features">
        <div class="container">
            <div class="features-title">Возможности</div>
            <h2 class="features-heading">Всё что нужно предпринимателю</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Дашборд</h3>
                    <p>Чистая прибыль, выручка, расходы, налоги, касса — все ключевые показатели на одном экране</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🧮</div>
                    <h3>Калькуляторы</h3>
                    <p>Налоговый калькулятор для упрощённого режима (3%) и расчёт себестоимости товаров и услуг</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📈</div>
                    <h3>Отчёты</h3>
                    <p>P&L, структура расходов, динамика выручки и прибыли. Экспорт в PDF одним нажатием</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Зарплаты</h3>
                    <p>Расчёт ФОТ с учётом всех отчислений: ОПВ, ИПН, СО, ОСМС. Режимы «на руки» и «начисленная»</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏦</div>
                    <h3>Касса</h3>
                    <p>Учёт поступлений и выбытий, остаток прошлых периодов, контроль денежных потоков</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🌙</div>
                    <h3>Тёмная и светлая тема</h3>
                    <p>Bloomberg-стиль для профессионалов. Поддержка русского и казахского языков</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="contact-wrapper">
                <h2>Служба поддержки</h2>
                <p class="contact-subtitle">Напишите нам и мы ответим в ближайшее время</p>

                @if(session('success'))
                    <div class="success-message">
                        Спасибо! Ваше сообщение отправлено. Мы свяжемся с вами в ближайшее время.
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Ваше имя</label>
                        <input type="text" id="name" name="name" placeholder="Как к вам обращаться" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="your@email.com" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="message">Сообщение</label>
                        <textarea id="message" name="message" placeholder="Опишите ваш вопрос или проблему" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="submit-btn">Отправить</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-links">
                <a href="/legal/terms.html">Пользовательское соглашение</a>
                <a href="/legal/privacy.html">Политика конфиденциальности</a>
                <a href="/legal/offer.html">Публичная оферта</a>
            </div>
            <div class="footer-copy">&copy; {{ date('Y') }} Profex. Все права защищены.</div>
        </div>
    </footer>

</body>
</html>
