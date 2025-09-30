<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('overview') ? 'active' : '' }}"
                        href="{{ route('overview') }}">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('translation.overview')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('manage-categories.index', 'manage-categories.create', 'manage-categories.edit') ? 'active' : '' }}"
                        href="{{ route('manage-categories.index') }}">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('translation.categories')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="products">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('translation.products')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="warehouses">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('translation.warehouses')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="merchants">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('translation.merchants')</span>
                    </a>
                </li>


                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.pages')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="roles">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('translation.roles')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-pages-line"></i> <span>@lang('translation.manage-users')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPages">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="pages-starter" class="nav-link">@lang('translation.users-list')</a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-starter" class="nav-link">@lang('translation.assign-role')</a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="setting">
                        <i class="ri-account-circle-line"></i> <span>@lang('translation.settings')</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
