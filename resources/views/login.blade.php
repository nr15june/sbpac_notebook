<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <title>เข้าสู่ระบบ | ระบบยืมโน้ตบุ๊ก ศอ.บต.</title>
    <link rel="icon" type="image/png" href="{{ asset('images/sbpac-logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Sarabun", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #ffffff;
        }

        .login-wrapper {
            width: 470px;
            max-width: 90%;
            background: #FFFBFB;
            border-radius: 10px;
            padding: 40px 40px 45px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, .08);
        }

        .logo-row {
            display: flex;
            align-items: center;
            margin-bottom: 28px;
        }

        .logo-row img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 18px;
        }

        .logo-text-th {
            font-size: 16px;
            font-weight: 700;
        }

        .logo-text-en {
            font-size: 12px;
            color: #555;
            margin-top: 3px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #444;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .btn-login {
            margin-top: 35px;
            display: block;
            width: 140px;
            margin-left: auto;
            margin-right: auto;
            padding: 10px 0;
            background: #787878;
            color: #fff;
            border: none;
            border-radius: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #5f5f5f;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        <div class="logo-row">
            <img src="{{ asset('images/sbpac-logo.png') }}" alt="">
            <div>
                <div class="logo-text-th">ศูนย์อำนวยการบริหารจังหวัดชายแดนภาคใต้</div>
                <div class="logo-text-en">Southern Border Provinces Administrative Centre</div>
            </div>
        </div>

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="form-group">
                <div class="form-label">Username</div>
                <input type="text" name="username" class="form-control" placeholder="username">

            </div>

            <div class="form-group">
                <div class="form-label">Password</div>
                <input type="password" name="password" class="form-control" placeholder="password">
            </div>

            <button type="submit" class="btn-login">LOGIN</button>
        </form>

    </div>
</body>

</html>