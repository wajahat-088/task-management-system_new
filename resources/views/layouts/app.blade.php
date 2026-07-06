<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('favicon1.png') }}" type="image/png">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Google Fonts: Sora (headings/numbers) + Inter (body/labels) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts / Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="app-shell">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="site-header">
                    <div class="page-container site-header__inner">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <div id="toast" class="toast"></div>

        <script>
            function showToast(message, type = 'success') {
                const toast = document.getElementById('toast');
                toast.textContent = message;
                toast.className = 'toast toast--show ' + (type === 'success' ? 'toast--success' : 'toast--error');
                setTimeout(() => {
                    toast.classList.remove('toast--show');
                }, 3000);
            }

            @if(session('success'))
                document.addEventListener('DOMContentLoaded', () => {
                    showToast(@json(session('success')), 'success');
                });
            @endif
        </script>
    </body>
</html>