<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PINAKU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --primary-color: #0e9a7e;
            --primary-dark: #076d59;
            --bg-dark: #1f5f59;
            --text-white: #ffffff;
            --text-muted: #e9f5ee;
        }

        body, h1, h2, h3, h4, h5, h6, p, label, .form-control {
            color: #1B5E58;
        }

        body {
            font-family: 'Josefin Sans', sans-serif;
            background-color: var(--bg-dark);
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-card {
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 880px;
        }

        .btn-role {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 16px;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid transparent;
            background: #f8faf9;
            color: #1B5E58;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .btn-role:hover {
            transform: scale(1.02);
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 10px 20px rgba(14, 154, 126, 0.1);
        }

        .btn-role .icon {
            font-size: 1.5rem;
            background: var(--primary-color);
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            color: white;
            flex-shrink: 0;
        }

        .btn-role strong {
            display: block;
            font-size: 1rem;
            color: #1B5E58;
        }

        .btn-role small {
            color: #1B5E58;
            opacity: 0.8;
            font-size: 0.8rem;
        }

        .image-wrapper {
            position: relative;
            height: 100%;
            min-height: 400px;
            background: var(--primary-color);
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 50%);
        }

        .image-text {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
            color: #fff;
            z-index: 2;
        }

        .image-text h3 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .register-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .register-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }


    </style>
</head>
<body style="background:#1f5f59;">
    @yield('content')
</body>
</html>
