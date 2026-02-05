<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'ระบบยืมโน้ตบุ๊ก | ศอ.บต.')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/sbpac-logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>sbpac meetingroom</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts  -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    {{-- ถ้ายังไม่ได้ build ให้ใช้ Tailwind CDN ชั่วคราว --}}
    <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-slate-50 min-h-screen flex items-center justify-center">

    <div class="w-full px-4 text-center">
        {{-- โลโก้หน่วยงาน --}}
        <div class="flex justify-center mb-8">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-full overflow-hidden border-[6px] border-yellow-500 shadow">
                <img
                    src="{{ asset('images/sbpac-logo.png') }}"
                    alt="ศูนย์อำนวยการบริหารจังหวัดชายแดนภาคใต้"
                    class="w-full h-full object-contain bg-black">
            </div>
        </div>

        <h1 class="text-2xl md:text-3xl font-semibold text-slate-900">
            ศูนย์อำนวยการบริหารจังหวัดชายแดนภาคใต้
        </h1>

        <p class="mt-2 text-base md:text-lg text-slate-600">
            Southern Border Provinces Administrative Centre
        </p>

        <div class="mt-10">
            <a
                href=""
                class="inline-flex items-center justify-center px-10 py-4 rounded-full text-white text-base md:text-lg font-medium
                           bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-300
                           shadow-md transition">
                <span class="mr-2">ระบบยืมโน้ตบุ๊ก</span>
                <span class="text-xl">➜</span>
            </a>
        </div>
    </div>

</body>

</html>