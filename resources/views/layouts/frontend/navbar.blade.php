<nav class="navbar navbar-expand-lg navbar-white border-bottom border-danger">
    <div class="container-fluid">
        <a href="{{ route('donor') }}" class="app-brand-link m-auto text-decoration-none">
            <span class="app-brand-logo demo">
                <div class="d-flex flex-column align-items-center" style="margin-top: 15px;">
                    <img src="{{ asset('assets/img/logo.jpeg') }}" alt="Donor Darah Logo" style="height: 50px; width: auto;">
                </div>
            </span>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('donor', 'donor.detail') ? 'text-danger border-bottom border-danger' : '' }}" aria-current="page" href="{{ route('donor') }}">Donor</a>
                </li>
                    <a class="nav-link {{ Route::is('category1') ? 'text-danger border-bottom border-danger' : '' }}" aria-current="page" href="{{ route('category1') }}">Pendonor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('category2') ? 'text-danger border-bottom border-danger' : '' }}" aria-current="page" href="{{ route('category2') }}">Permohonan darah</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('announcement') ? 'text-danger border-bottom border-danger' : '' }}" aria-current="page" href="{{ route('announcement') }}">Informasi</a>
                </li>
            </ul>   
            @if (Auth::check())
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="nav-link">Logout</button>
                        </form>
                    </li>
                    @if (Auth::user()->role->name == 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    @endif
                </ul>
            @endif
        </div>
    </div>
</nav>