<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedai Cendana - Akses Dilarang</title>
    <link rel="shortcut icon" href="{{ asset('images/kedai-cendana-rounded.webp') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <style>
        :root {
            --primary-dark: #222222;
            --accent-color: #ffd67c;
            --text-secondary: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .error-wrapper {
            position: relative;
            padding: 2rem;
            text-align: center;
            animation: fadeIn 0.8s ease-out;
        }

        .brand-logo {
            max-width: 100px;
            margin-bottom: 3rem;
            opacity: 0.9;
        }

        .error-code {
            font-size: clamp(8rem, 20vw, 12rem);
            font-weight: 800;
            line-height: 0.8;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
            letter-spacing: -0.05em;
        }

        .error-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .error-desc {
            color: var(--text-secondary);
            max-width: 400px;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            padding: 1rem 2.5rem;
            background-color: var(--primary-dark);
            color: #ffffff;
            font-weight: 600;
            border-radius: 100px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid var(--primary-dark);
        }

        .btn-action:hover {
            background-color: transparent;
            color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dynamic blob background */
        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(231, 76, 60, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            z-index: -1;
            filter: blur(50px);
        }

        .blob-1 {
            top: -20%;
            left: -10%;
            animation: float 15s infinite alternate;
        }

        .blob-2 {
            bottom: -20%;
            right: -10%;
            animation: float 12s infinite alternate-reverse;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) scale(1);
            }

            100% {
                transform: translate(50px, 30px) scale(1.1);
            }
        }
    </style>
</head>

<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="error-wrapper">
        <a href="/">
            <img src="{{ asset('images/logo_cendana.webp') }}" alt="Kedai Cendana" class="brand-logo">
        </a>
        <div class="error-code">403</div>
        <h1 class="error-title">Akses Dilarang</h1>
        <p class="error-desc">Maaf, pintu gerbang ini tertutup untuk Anda. Silakan kembali ke jalan yang benar.</p>
        <a href="/" class="btn-action">
            <i class="bi bi-house-door me-2"></i>Kembali Beranda
        </a>
    </div>
</body>

</html>
