<?php

require_once "config/session.php";

?>

<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daily-Istory</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fbff;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        /*
        |--------------------------------------------------------------------------
        | Navbar
        |--------------------------------------------------------------------------
        */

        .navbar {
            inline-size: 100%;
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            position: fixed;
            inset-block-start: 0;
            inset-inline-start: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .logo {
            font-size: 30px;
            font-weight: 800;
            color: #2563eb;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .nav-buttons a {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .login-btn {
            border: 2px solid #2563eb;
            color: #2563eb;
        }

        .login-btn:hover {
            background: #2563eb;
            color: white;
        }

        .register-btn {
            background: #2563eb;
            color: white;
        }

        .register-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.25);
        }

        /*
        |--------------------------------------------------------------------------
        | Hero
        |--------------------------------------------------------------------------
        */

        .hero {
            min-block-size: 100vh;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 130px 8% 50px;
            gap: 60px;
        }

        .hero-text {
            flex: 1;
        }

        .hero-text h1 {
            font-size: 72px;
            line-height: 1.1;
            color: #0f172a;
            margin-block-end: 25px;
        }

        .hero-text span {
            color: #2563eb;
        }

        .hero-text p {
            font-size: 20px;
            color: #475569;
            line-height: 1.8;
            margin-block-end: 35px;
            max-inline-size: 650px;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .hero-buttons a {
            padding: 16px 34px;
            border-radius: 14px;
            font-weight: 600;
            transition: 0.3s;
        }

        .start-btn {
            background: #2563eb;
            color: white;
        }

        .start-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.25);
        }

        .about-btn {
            border: 2px solid #2563eb;
            color: #2563eb;
        }

        .about-btn:hover {
            background: #2563eb;
            color: white;
        }

        /*
        |--------------------------------------------------------------------------
        | Hero Card
        |--------------------------------------------------------------------------
        */

        .hero-card {
            flex: 1;
            background: white;
            border-radius: 30px;
            padding: 35px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.08);
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-block-end: 30px;
        }

        .mini-box {
            flex: 1;
            background: #eff6ff;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
        }

        .mini-box h3 {
            color: #2563eb;
            font-size: 32px;
            margin-block-end: 8px;
        }

        .mini-box p {
            color: #64748b;
            font-size: 14px;
        }

        .task {
            background: #f8fbff;
            border-inline-start: 5px solid #2563eb;
            border-radius: 18px;
            padding: 18px;
            margin-block-end: 18px;
        }

        .task h4 {
            color: #0f172a;
            margin-block-end: 8px;
        }

        .task p {
            color: #64748b;
            font-size: 14px;
        }

        /*
        |--------------------------------------------------------------------------
        | Features
        |--------------------------------------------------------------------------
        */

        .features {
            padding: 100px 8%;
            background: white;
        }

        .section-title {
            text-align: center;
            margin-block-end: 70px;
        }

        .section-title h2 {
            font-size: 50px;
            color: #0f172a;
            margin-block-end: 15px;
        }

        .section-title p {
            color: #64748b;
            font-size: 18px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: #f8fbff;
            padding: 35px;
            border-radius: 24px;
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.06);
        }

        .feature-icon {
            font-size: 45px;
            margin-block-end: 20px;
        }

        .feature-card h3 {
            color: #0f172a;
            margin-block-end: 15px;
        }

        .feature-card p {
            color: #64748b;
            line-height: 1.8;
        }

        /*
        |--------------------------------------------------------------------------
        | Footer
        |--------------------------------------------------------------------------
        */

        .footer {
            background: #2563eb;
            color: white;
            text-align: center;
            padding: 25px;
            margin-block-start: 50px;
        }

        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media(max-inline-size:950px) {

            .hero {
                flex-direction: column;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 50px;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-card {
                inline-size: 100%;
            }
        }

        @media(max-inline-size:600px) {

            .navbar {
                padding: 20px;
            }

            .hero {
                padding: 120px 20px 50px;
            }

            .features {
                padding: 80px 20px;
            }

            .hero-text h1 {
                font-size: 40px;
            }

            .section-title h2 {
                font-size: 36px;
            }

            .nav-buttons a {
                padding: 10px 18px;
                font-size: 14px;
            }
        }
    </style>

</head>

<body>

    <!-- Navbar -->

    <div class="navbar">

        <div class="logo">
            Daily-Istory
        </div>

        <div class="nav-buttons">

            <a href="auth/login.php" class="login-btn">
                Kirish
            </a>

            <a href="auth/register.php" class="register-btn">
                Boshlash
            </a>

        </div>

    </div>



    <!-- Hero -->

    <section class="hero">

        <div class="hero-text">

            <h1>

                Kuningizni
                <span>Rejalashtiring.</span>

            </h1>

            <p>

                Daily-Istory sizga kunlik rejalarni yozish,
                vaqtni boshqarish, bajarilgan vazifalarni
                kuzatish va maqsadlaringizni nazorat qilishda yordam beradi.

            </p>

            <div class="hero-buttons">

                <a href="auth/register.php" class="start-btn">
                    Reja Tuzishni Boshlash
                </a>

                <a href="#features" class="about-btn">
                    Batafsil
                </a>

            </div>

        </div>



        <!-- Hero Card -->

        <div class="hero-card">

            <div class="card-top">

                <div class="mini-box">
                    <h3>24</h3>
                    <p>Jami Rejalar</p>
                </div>

                <div class="mini-box">
                    <h3>18</h3>
                    <p>Bajarilgan</p>
                </div>

            </div>


            <div class="task">

                <h4>
                    📚 PHP loyiha ustida ishlash
                </h4>

                <p>
                    14:00 • Bajarildi
                </p>

            </div>


            <div class="task">

                <h4>
                    🏋️ Sport mashg‘uloti
                </h4>

                <p>
                    18:00 • Jarayonda
                </p>

            </div>


            <div class="task">

                <h4>
                    🎯 Ingliz tili mashqi
                </h4>

                <p>
                    21:00 • Kutilmoqda
                </p>

            </div>

        </div>

    </section>



    <!-- Features -->

    <section class="features" id="features">

        <div class="section-title">

            <h2>
                Nima uchun Daily-Istory?
            </h2>

            <p>
                Kunlik rejalaringizni boshqarish uchun zamonaviy platforma.
            </p>

        </div>



        <div class="feature-grid">

            <div class="feature-card">

                <div class="feature-icon">
                    📅
                </div>

                <h3>
                    Aqlli Rejalashtirish
                </h3>

                <p>
                    Kunlik rejalarni yozing,
                    vaqtni samarali boshqaring
                    va maqsadlaringizni tartibga soling.
                </p>

            </div>



            <div class="feature-card">

                <div class="feature-icon">
                    🔒
                </div>

                <h3>
                    Vaqt Nazorati
                </h3>

                <p>
                    O‘tib ketgan rejalar avtomatik
                    bloklanadi va tarix saqlab qolinadi.
                </p>

            </div>



            <div class="feature-card">

                <div class="feature-icon">
                    📊
                </div>

                <h3>
                    Statistika va Tarix
                </h3>

                <p>
                    Bajarilgan, bajarilmagan
                    va kutilayotgan rejalarni kuzating.
                </p>

            </div>

        </div>

    </section>



    <!-- Footer -->

    <div class="footer">

        © 2026 Daily-Istory • Kunlik Rejalashtirish Platformasi

    </div>

</body>

</html>