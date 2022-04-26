<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <title>{{ $title ?? 'Atelier Home Design' }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  @stack('head')
</head>
<body class="h-screen">
<x-nav/>
<div>
  {{ $slot }}
</div>
<x-footer/>
<script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@stack('scripts')
</body>
</html>
