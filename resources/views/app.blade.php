<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" viewport-fit="cover">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <!-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> -->
        <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
       
        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        <!-- <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyD2CYYH2ADybStaE1le_M5njhHExqT4Izg&callback=Function.prototype"></script> -->
        <!-- アナリティクス -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-Z22SFFPQCK"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-Z22SFFPQCK');
        </script>
        <script>
            if('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js', { scope: '/' })
            })
            }
        </script>
        <!-- アドセンス -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4513285824099190" crossorigin="anonymous"></script>
    </head>
    <body class="bg-[#FFF3E0]">
        @inertia
    </body>
</html>

<style>
    body{
        font-family: 'M PLUS Rounded 1c', sans-serif;
    }
</style>
