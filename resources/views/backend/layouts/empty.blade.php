<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    @include('backend.include.head')
</head>

<body class="hold-transition dark-mode login-page">


    @yield('content')


    @include('backend.include.footer')
    @include('backend.include.alerts')
    @yield('js')


    
</body>

</html>