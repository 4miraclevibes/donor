<footer class="bg-danger text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <p>Platform donor darah yang menghubungkan pendonor dengan mereka yang membutuhkan donor darah. Kami berkomitmen untuk memudahkan proses donor darah dan membantu menyelamatkan nyawa melalui donor darah. Bergabunglah dengan komunitas kami untuk berbagi kehidupan melalui donor darah.</p>
            </div>
            <div class="col-md-2">
                <h5>Menu Utama</h5>
                <ul class="list-unstyled">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('donor', 'donor.detail') ? 'fw-bold text-warning' : '' }}" aria-current="page" href="{{ route('donor') }}">Donor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('category1') ? 'fw-bold text-warning' : '' }}" aria-current="page" href="{{ route('category1') }}">Pendonor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('category2') ? 'fw-bold text-warning' : '' }}" aria-current="page" href="{{ route('category2') }}">Permohonan darah</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('announcement') ? 'fw-bold text-warning' : '' }}" aria-current="page" href="{{ route('announcement') }}">Informasi</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2">
                <h5>Hubungi Kami</h5>
                <div class="d-flex flex-column gap-2">
                    <a href="https://www.instagram.com/donordarahyokk?igsh=d2I3aW56MHF0N3Rs" class="text-white text-decoration-none" target="_blank">
                        <i class="fab fa-instagram fa-lg me-2"></i>
                        <span>donordarahyukk</span>
                    </a>
                    <a href="mailto:info@donordarahyuk.com" class="text-white text-decoration-none">
                        <i class="fas fa-envelope fa-lg me-2"></i>
                        <span>info@donordarahyuk.com</span>
                    </a>
                    <a href="tel:+628123456789" class="text-white text-decoration-none">
                        <i class="fas fa-phone fa-lg me-2"></i>
                        <span>0812-3456-789</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <hr class="border-top border-light">
            <div class="col-11">
                <p class="mb-0">Copyright 2024 DonorDarahYuk, All rights reserved</p>
            </div>
        </div>
    </div>
</footer>
