@section('leftmenu')
@php

use App\Models\backend\BackendMenubar;
use App\Models\backend\BackendSubMenubar;
use Spatie\Permission\Models\Role;

$user_id = Auth()->guard('admin')->user()->id;
$role_id = Auth()->guard('admin')->user()->role_id;

$user_role = Role::where('id',$role_id)->first();

$menu_ids=explode(",",$user_role->menu_ids);
$submenu_ids=explode(",",$user_role->submenu_ids);

$backend_menubar = BackendMenubar::WhereIn('menu_id',$menu_ids)->Where(['visibility'=>1])->orderBy('sort_order')->get();
@endphp


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('public/images/fav_icon.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Shady Sales</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('public/admin_user_profile/' .  Auth()->guard('admin')->user()->profile_pic)}}"
                    class="img-circle elevation-2" alt="User Image" style="height:40px !important;">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth()->guard('admin')->user()->full_name}}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Request::is('admin') ? ' active' : '' }}">
                        <i class="nav-icon far fa-circle text-success"></i>
                        <p class="text">Dashboard</p>
                        <span class="right badge badge-success">Home</span>
                    </a>
                </li>

                @foreach($backend_menubar as $menu)
                @php
                $isActiveMenu = false;
                $isActiveSubMenu = false;
                $backend_submenubar =
                BackendSubMenubar::WhereIn('submenu_id',$submenu_ids)->Where(['menu_id'=>$menu->menu_id])->Where(['visibility'=>1])->get();
                @endphp
                @foreach($backend_submenubar as $submenu)
                @if(Request::is($submenu->submenu_controller_name))
                @php
                $isActiveMenu = true;
                $isActiveSubMenu = true;
                @endphp
                @endif
                @endforeach
                <li class="nav-item {{ $isActiveMenu ? ' menu-open' : '' }}">
                    <a href="{{ $menu->url }}" class="nav-link {{ $isActiveMenu ? ' active' : '' }}">
                        <i class="nav-icon fas fa-{{ $menu->menu_icon }}"></i>
                        <p>
                            {{ $menu->menu_name }}
                            @if($menu->has_submenu)
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">{{count($backend_submenubar)}}</span>
                            @endif
                        </p>
                    </a>
                    @if($menu->has_submenu)
                    <ul class="nav nav-treeview">
                        @foreach($backend_submenubar as $submenu)
                        <li class="nav-item">
                            <a href="{{ route($submenu->submenu_controller_name) }}"
                                class="nav-link {{ $isActiveSubMenu ? ' active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ $submenu->submenu_name }}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


@section('js')
<script>
    $(document).ready(function () {

        // Add 'active' class to current page's menu and submenu
        $('ul.nav-sidebar a').removeClass('active');
        var currentPageUrl = location.href;
        $('ul.nav-sidebar a').each(function() {
        var $menuItem = $(this);
        if ($menuItem.attr('href') === currentPageUrl) {
            $menuItem.addClass('active');
            $menuItem.closest('.nav-treeview').css('display', 'block');
            $menuItem.parents('.nav-item').addClass('menu-open').children('a').addClass('active');
            return false; // Exit the loop once the current page's menu item is found
        }
    });
    });
</script>