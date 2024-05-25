<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    @include('backend.include.head')
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    @include('backend.include.header')
    @include('backend.include.leftmenu')

    @yield('content')


    @include('backend.include.footer')
    @include('backend.include.alerts')
    @yield('js')


    
</body>

</html>