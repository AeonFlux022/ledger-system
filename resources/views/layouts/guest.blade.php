<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Login')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative flex items-center justify-center min-h-screen bg-cover bg-center text-gray-900"
  style="background-image: url('{{ asset('/images/login-bg.jpg') }}');">

  <!-- Blur and dark overlay -->
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

  <!-- Page content -->
  <div class="relative z-10 w-full flex items-center justify-center px-4">
    @yield('content')
  </div>

</body>

</html>
