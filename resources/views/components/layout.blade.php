<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <title>{{ $title ?? 'Atelier Home Design' }}</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
  @stack('head')
</head>
<body class="h-screen">
  <x-nav/>
  <div>
    {{ $slot }}
  </div>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@stack('scripts')
</body>
</html>
