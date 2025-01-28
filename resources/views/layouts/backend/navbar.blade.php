        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{ route('donor') }}" class="app-brand-link m-auto">
                    <span class="app-brand-logo demo">
                        <div class="d-flex flex-column align-items-center" style="margin-top: 15px;">
                            <img src="{{ asset('assets/img/donor-logo.png') }}" alt="Donor Darah Logo" style="height: 30px; width: auto;">
                            <div style="font-family: Arial; color: #dc3545; font-size: 10px; font-weight: bold; letter-spacing: 1px; margin-top: 8px;">
                                DONOR DARAH
                            </div>
                        </div>
                    </span>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1 mt-3 border-top">
                <!-- Dashboard -->
                <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-home"></i>
                        <div data-i18n="Dashboard">Dashboard</div>
                    </a>
                </li>
                <!-- Users -->
                <li class="menu-item {{ Route::is('users*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-user"></i>
                        <div data-i18n="Users">Pengguna</div>
                    </a>
                </li>
                <!-- Announcement -->
                <li class="menu-item {{ Route::is('announcements*') ? 'active' : '' }}">
                    <a href="{{ route('announcements.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-news"></i>
                        <div data-i18n="Announcement">Informasi</div>
                    </a>
                </li>
                <!-- Donor --> 
                <li class="menu-item {{ Route::is('donors.index') ? 'active' : '' }}">
                    <a href="{{ route('donors.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-donate-heart"></i>
                        <div data-i18n="Donor">Donor</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('donors.category1') ? 'active' : '' }}">
                    <a href="{{ route('donors.category1') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-donate-heart"></i>
                        <div data-i18n="Donor">Pendonor</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('donors.category2') ? 'active' : '' }}">
                    <a href="{{ route('donors.category2') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-donate-heart"></i>
                        <div data-i18n="Donor">Permohonan Darah</div>
                    </a>
                </li>
            </ul>
        </aside>
        <!-- / Menu -->
