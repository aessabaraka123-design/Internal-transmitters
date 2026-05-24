<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS Messaging - نظام المراسلات الداخلي</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #0a0a1a;
            --accent: #4f6ef7;
            --accent2: #a855f7;
            --gold: #f59e0b;
            --light: #f8faff;
            --glass: rgba(255,255,255,0.05);
            --glass-border: rgba(255,255,255,0.1);
        }
 
        * { margin: 0; padding: 0; box-sizing: border-box; }
 
        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--primary);
            color: white;
            overflow-x: hidden;
        }
 
        /* Background */
        .bg-mesh {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 20%, rgba(79,110,247,0.15) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 80% 80%, rgba(168,85,247,0.12) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 50% 50%, rgba(245,158,11,0.05) 0%, transparent 70%);
        }
 
        .grid-overlay {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
        }
 
        /* Navbar */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            padding: 20px 0;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            background: rgba(10,10,26,0.8);
        }
 
        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
 
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
 
        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
 
        .logo-text {
            font-size: 1.3rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }
 
        .nav-links {
            display: flex;
            gap: 12px;
            align-items: center;
        }
 
        .btn-nav-login {
            padding: 10px 24px;
            border: 1px solid var(--glass-border);
            background: var(--glass);
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
            font-family: 'Tajawal', sans-serif;
        }
 
        .btn-nav-login:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.3);
            color: white;
        }
 
        .btn-nav-primary {
            padding: 10px 24px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 700;
            transition: all 0.3s;
            font-family: 'Tajawal', sans-serif;
            border: none;
        }
 
        .btn-nav-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            color: white;
        }
 
        /* Hero */
        .hero {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 40px 80px;
        }
 
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            background: rgba(79,110,247,0.15);
            border: 1px solid rgba(79,110,247,0.3);
            border-radius: 100px;
            font-size: 0.85rem;
            color: #93a8ff;
            margin-bottom: 32px;
            animation: fadeUp 0.6s ease forwards;
        }
 
        .hero-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
 
        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 5rem);
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -2px;
            margin-bottom: 24px;
            animation: fadeUp 0.6s ease 0.1s both;
        }
 
        .hero h1 .gradient-text {
            background: linear-gradient(135deg, #4f6ef7, #a855f7, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
 
        .hero p {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.6);
            max-width: 600px;
            margin: 0 auto 48px;
            line-height: 1.7;
            font-weight: 400;
            animation: fadeUp 0.6s ease 0.2s both;
        }
 
        .hero-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeUp 0.6s ease 0.3s both;
        }
 
        .btn-primary-hero {
            padding: 16px 40px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: white;
            border-radius: 14px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 700;
            transition: all 0.3s;
            font-family: 'Tajawal', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 0 40px rgba(79,110,247,0.3);
        }
 
        .btn-primary-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 60px rgba(79,110,247,0.5);
            color: white;
        }
 
        .btn-secondary-hero {
            padding: 16px 40px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            color: white;
            border-radius: 14px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s;
            font-family: 'Tajawal', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
 
        .btn-secondary-hero:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
            color: white;
        }
 
        /* Stats */
        .stats-bar {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 60px auto 0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: var(--glass-border);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--glass-border);
            animation: fadeUp 0.6s ease 0.4s both;
        }
 
        .stat-item {
            padding: 28px;
            background: rgba(255,255,255,0.03);
            text-align: center;
            backdrop-filter: blur(10px);
        }
 
        .stat-num {
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
 
        .stat-label {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.5);
            margin-top: 4px;
        }
 
        /* Features */
        .features {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 100px auto;
            padding: 0 40px;
        }
 
        .section-label {
            text-align: center;
            font-size: 0.85rem;
            color: var(--accent);
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
 
        .section-title {
            text-align: center;
            font-size: clamp(1.8rem, 3vw, 2.8rem);
            font-weight: 800;
            margin-bottom: 60px;
            letter-spacing: -1px;
        }
 
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
 
        .feature-card {
            padding: 36px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }
 
        .feature-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(79,110,247,0.05), transparent);
            opacity: 0;
            transition: opacity 0.4s;
        }
 
        .feature-card:hover {
            border-color: rgba(79,110,247,0.3);
            transform: translateY(-6px);
            box-shadow: 0 20px 60px rgba(79,110,247,0.1);
        }
 
        .feature-card:hover::before { opacity: 1; }
 
        .feature-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
 
        .icon-blue { background: rgba(79,110,247,0.15); color: #4f6ef7; }
        .icon-purple { background: rgba(168,85,247,0.15); color: #a855f7; }
        .icon-gold { background: rgba(245,158,11,0.15); color: #f59e0b; }
        .icon-green { background: rgba(34,197,94,0.15); color: #22c55e; }
        .icon-red { background: rgba(239,68,68,0.15); color: #ef4444; }
        .icon-cyan { background: rgba(6,182,212,0.15); color: #06b6d4; }
 
        .feature-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
 
        .feature-card p {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.5);
            line-height: 1.7;
        }
 
        /* Pricing */
        .pricing {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 100px auto;
            padding: 0 40px;
        }
 
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
 
        .pricing-card {
            padding: 40px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            transition: all 0.4s;
            position: relative;
        }
 
        .pricing-card.featured {
            background: linear-gradient(135deg, rgba(79,110,247,0.15), rgba(168,85,247,0.1));
            border-color: rgba(79,110,247,0.4);
            transform: scale(1.05);
        }
 
        .featured-badge {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            padding: 6px 20px;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 700;
            white-space: nowrap;
        }
 
        .plan-name {
            font-size: 1rem;
            font-weight: 700;
            color: rgba(255,255,255,0.6);
            margin-bottom: 12px;
        }
 
        .plan-price {
            font-size: 3rem;
            font-weight: 900;
            letter-spacing: -2px;
            margin-bottom: 4px;
        }
 
        .plan-period {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.4);
            margin-bottom: 32px;
        }
 
        .plan-features {
            list-style: none;
            margin-bottom: 32px;
        }
 
        .plan-features li {
            padding: 10px 0;
            border-bottom: 1px solid var(--glass-border);
            font-size: 0.9rem;
            color: rgba(255,255,255,0.7);
            display: flex;
            align-items: center;
            gap: 10px;
        }
 
        .plan-features li i { color: var(--accent); }
 
        .btn-plan {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Tajawal', sans-serif;
            text-decoration: none;
            display: block;
            text-align: center;
        }
 
        .btn-plan-outline {
            background: transparent;
            border: 1px solid var(--glass-border);
            color: white;
        }
 
        .btn-plan-outline:hover {
            background: var(--glass);
            color: white;
        }
 
        .btn-plan-filled {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none;
            color: white;
            box-shadow: 0 0 30px rgba(79,110,247,0.3);
        }
 
        .btn-plan-filled:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            color: white;
        }
 
        /* CTA */
        .cta {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 80px auto 100px;
            padding: 80px 60px;
            background: linear-gradient(135deg, rgba(79,110,247,0.1), rgba(168,85,247,0.08));
            border: 1px solid rgba(79,110,247,0.2);
            border-radius: 32px;
            text-align: center;
            overflow: hidden;
        }
 
        .cta h2 {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 16px;
            letter-spacing: -1px;
        }
 
        .cta p {
            color: rgba(255,255,255,0.6);
            margin-bottom: 40px;
            font-size: 1.1rem;
        }
 
        /* Footer */
        footer {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 40px;
            border-top: 1px solid var(--glass-border);
            color: rgba(255,255,255,0.3);
            font-size: 0.85rem;
        }
 
        /* Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
 
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
 
        @media (max-width: 768px) {
            .features-grid, .pricing-grid { grid-template-columns: 1fr; }
            .stats-bar { grid-template-columns: 1fr; }
            .pricing-card.featured { transform: none; }
            .nav-inner { padding: 0 20px; }
            .hero { padding: 100px 20px 60px; }
        }
    </style>
</head>
<body>
 
<div class="bg-mesh"></div>
<div class="grid-overlay"></div>
 
<!-- Navbar -->
<nav>
    <div class="nav-inner">
        <a href="/" class="logo">
            <div class="logo-icon">💬</div>
            <span class="logo-text">SaaS Messaging</span>
        </a>
        <div class="nav-links">
            <a href="{{ route('tenant.login') }}" class="btn-nav-login">
                <i class="bi bi-person-circle"></i> دخول الموظف
            </a>
            <a href="{{ route('super-admin.login') }}" class="btn-nav-login">
                <i class="bi bi-shield-lock"></i> دخول المدير
            </a>
            <a href="{{ route('register') }}" class="btn-nav-primary">
                <i class="bi bi-rocket-takeoff"></i> ابدأ مجاناً
            </a>
        </div>
    </div>
</nav>
 
<!-- Hero -->
<section class="hero">
    <div>
        <div class="hero-badge">
            <span>🚀 النظام يعمل الآن</span>
        </div>
        <h1>
            نظام المراسلات<br>
            <span class="gradient-text">الداخلي السحابي</span>
        </h1>
        <p>منصة متكاملة لإدارة التواصل الداخلي بين موظفي شركتك — آمنة، سريعة، وسهلة الاستخدام</p>
        <div class="hero-buttons">
            <a href="{{ route('register') }}" class="btn-primary-hero">
                <i class="bi bi-rocket-takeoff"></i>
                ابدأ تجربتك المجانية
            </a>
            <a href="{{ route('tenant.login') }}" class="btn-secondary-hero">
                <i class="bi bi-box-arrow-in-right"></i>
                تسجيل الدخول
            </a>
        </div>
 
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-num">14</div>
                <div class="stat-label">يوم تجريبي مجاني</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">∞</div>
                <div class="stat-label">رسائل داخلية</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">100%</div>
                <div class="stat-label">بيانات معزولة وآمنة</div>
            </div>
        </div>
    </div>
</section>
 
<!-- Features -->
<section class="features">
    <div class="section-label">المميزات</div>
    <h2 class="section-title">كل ما تحتاجه في مكان واحد</h2>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon-wrap icon-blue">
                <i class="bi bi-database-lock"></i>
            </div>
            <h3>قاعدة بيانات منفصلة</h3>
            <p>كل شركة تحصل على قاعدة بيانات مستقلة وآمنة تماماً — بياناتك لا تختلط أبداً</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon-wrap icon-purple">
                <i class="bi bi-chat-dots"></i>
            </div>
            <h3>مراسلات فورية</h3>
            <p>تواصل فعّال بين الموظفين مع دعم المرفقات والمحادثات الخاصة</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon-wrap icon-gold">
                <i class="bi bi-people"></i>
            </div>
            <h3>إدارة الموظفين</h3>
            <p>تحكم كامل في صلاحيات الموظفين وإدارة الأدوار بسهولة</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon-wrap icon-green">
                <i class="bi bi-shield-check"></i>
            </div>
            <h3>أمان عالي المستوى</h3>
            <p>تشفير كامل للبيانات مع حماية متعددة الطبقات لضمان خصوصيتك</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon-wrap icon-cyan">
                <i class="bi bi-speedometer2"></i>
            </div>
            <h3>لوحة تحكم متكاملة</h3>
            <p>إحصائيات شاملة وتقارير تفصيلية لمتابعة نشاط شركتك</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon-wrap icon-red">
                <i class="bi bi-cloud"></i>
            </div>
            <h3>سحابي بالكامل</h3>
            <p>لا حاجة لتثبيت أي برنامج — الوصول من أي جهاز وفي أي وقت</p>
        </div>
    </div>
</section>
 
<!-- Pricing -->
<section class="pricing">
    <div class="section-label">الأسعار</div>
    <h2 class="section-title">خطط تناسب جميع الاحتياجات</h2>
    <div class="pricing-grid">
        <div class="pricing-card">
            <div class="plan-name">الأساسي</div>
            <div class="plan-price">مجاناً</div>
            <div class="plan-period">14 يوم تجريبي</div>
            <ul class="plan-features">
                <li><i class="bi bi-check-circle-fill"></i> حتى 10 موظفين</li>
                <li><i class="bi bi-check-circle-fill"></i> مراسلات داخلية</li>
                <li><i class="bi bi-check-circle-fill"></i> قاعدة بيانات مستقلة</li>
                <li><i class="bi bi-check-circle-fill"></i> دعم عبر البريد</li>
            </ul>
            <a href="{{ route('register') }}" class="btn-plan btn-plan-outline">ابدأ مجاناً</a>
        </div>
 
        <div class="pricing-card featured">
            <div class="featured-badge">⭐ الأكثر شيوعاً</div>
            <div class="plan-name">الاحترافي</div>
            <div class="plan-price">$49</div>
            <div class="plan-period">شهرياً</div>
            <ul class="plan-features">
                <li><i class="bi bi-check-circle-fill"></i> حتى 50 موظفاً</li>
                <li><i class="bi bi-check-circle-fill"></i> مرفقات حتى 5GB</li>
                <li><i class="bi bi-check-circle-fill"></i> تقارير متقدمة</li>
                <li><i class="bi bi-check-circle-fill"></i> دعم أولوي</li>
            </ul>
            <a href="{{ route('register') }}" class="btn-plan btn-plan-filled">اشترك الآن</a>
        </div>
 
        <div class="pricing-card">
            <div class="plan-name">المؤسسي</div>
            <div class="plan-price">$149</div>
            <div class="plan-period">شهرياً</div>
            <ul class="plan-features">
                <li><i class="bi bi-check-circle-fill"></i> موظفون غير محدودين</li>
                <li><i class="bi bi-check-circle-fill"></i> مرفقات غير محدودة</li>
                <li><i class="bi bi-check-circle-fill"></i> API مخصص</li>
                <li><i class="bi bi-check-circle-fill"></i> دعم على مدار الساعة</li>
            </ul>
            <a href="{{ route('register') }}" class="btn-plan btn-plan-outline">تواصل معنا</a>
        </div>
    </div>
</section>
 
<!-- CTA -->
<div style="padding: 0 40px;">
    <div class="cta">
        <h2>جاهز للبدء؟ 🚀</h2>
        <p>انضم إلى الشركات التي تستخدم نظامنا لتحسين تواصلها الداخلي</p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('register') }}" class="btn-primary-hero">
                <i class="bi bi-rocket-takeoff"></i>
                ابدأ تجربتك المجانية
            </a>
            <a href="{{ route('tenant.login') }}" class="btn-secondary-hero">
                <i class="bi bi-box-arrow-in-right"></i>
                لديك حساب؟ ادخل الآن
            </a>
        </div>
    </div>
</div>
 
<!-- Footer -->
<footer>
    <p>© 2026 SaaS Messaging — جميع الحقوق محفوظة</p>
</footer>
 
</body>
</html>
 