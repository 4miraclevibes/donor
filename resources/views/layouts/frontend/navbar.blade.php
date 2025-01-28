<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('donor') }}">
            DonorDarah
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('donor', 'donor.detail') ? 'active' : '' }}" aria-current="page" href="{{ route('donor') }}">Donor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('category1') ? 'active' : '' }}" aria-current="page" href="{{ route('category1') }}">Pendonor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('category2') ? 'active' : '' }}" aria-current="page" href="{{ route('category2') }}">Permohonan darah</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('announcement') ? 'active' : '' }}" aria-current="page" href="{{ route('announcement') }}">Informasi</a>
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