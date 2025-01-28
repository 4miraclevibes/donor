@extends('layouts.frontend.main')

@section('style')
<style>
    .required:after {
        content: ' *';
        color: red;
    }

    /* Style untuk tampilan mobile yang lebih compact */
    .card {
        margin-bottom: 0.8rem !important;
    }

    .card-header {
        padding: 0.5rem 1rem !important;
    }

    .card-body {
        padding: 0.8rem !important;
    }

    .mb-3 {
        margin-bottom: 0.5rem !important;
    }

    .form-label {
        margin-bottom: 0.2rem !important;
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        padding: 0.3rem 0.5rem !important;
        font-size: 0.9rem;
    }

    .content {
        padding: 0.8rem !important;
    }

    h2 {
        font-size: 1.5rem !important;
        margin-bottom: 1rem !important;
    }

    h5 {
        font-size: 1rem !important;
        margin-bottom: 0 !important;
    }

    textarea {
        height: 60px !important;
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }

    .border-bottom:last-child {
        border-bottom: none !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
</style>
@endsection

@section('content')
<div class="container content mt-5 mb-5">
    <!-- List Donor Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5>Riwayat Donor Saya</h5>
                </div>
                <div class="card-body">
                    @forelse($donors as $donor)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge {{ $donor->category ? 'bg-success' : 'bg-danger' }} me-2">
                                        {{ $donor->category ? 'Mendonor' : 'Butuh Donor' }}
                                    </span>
                                    <span class="badge {{ $donor->status == 'pending' ? 'bg-warning' : ($donor->status == 'done' ? 'bg-success' : 'bg-danger') }}">
                                        {{ ucfirst($donor->status) }}
                                    </span>
                                </div>
                                
                                <div class="d-flex align-items-center gap-2">
                                    @if($donor->status == 'pending')
                                        <form action="{{ route('donor.update.status', $donor->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="done">
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-check me-1"></i>Selesai
                                            </button>
                                        </form>
                                        <form action="{{ route('donor.update.status', $donor->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="failed">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times me-1"></i>Gagal
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('donor.detail', $donor->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-info-circle me-1"></i>Detail
                                    </a>
                                    <small class="text-muted ms-3">{{ $donor->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <i class="fas fa-tint text-danger me-2"></i>
                                        <strong>Golongan {{ $donor->golongan_darah }}</strong> 
                                        ({{ $donor->amount }} kantong)
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-phone text-success me-2"></i>
                                        {{ $donor->phone }}
                                    </p>
                                    @if($donor->message)
                                        <p class="mb-1">
                                            <i class="fas fa-comment text-primary me-2"></i>
                                            {{ $donor->message }}
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        {{ $donor->village->name }}, {{ $donor->district->name }}
                                    </p>
                                    <p class="mb-1">
                                        {{ $donor->city->name }}, {{ $donor->province->name }}
                                    </p>
                                    @if($donor->address)
                                        <p class="mb-1">
                                            <i class="fas fa-home text-secondary me-2"></i>
                                            {{ $donor->address }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="fas fa-info-circle text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada riwayat donor</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Existing Form Section -->
    <h2>Form Donor Darah</h2>

    <form action="{{ route('donor.store') }}" method="POST" class="row g-4">
        @csrf
        <div class="col-md-6 pe-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5>Data Donor</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Kategori</label>
                            <select class="form-select" name="category" id="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="1">Mendonor</option>
                                <option value="0">Butuh Donor</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Golongan Darah</label>
                            <select class="form-select" name="golongan_darah" id="golongan_darah" required>
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Jumlah Kantong</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-secondary btn-minus">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" class="form-control text-center" 
                                       name="amount" 
                                       value="1" 
                                       readonly 
                                       required>
                                <button type="button" class="btn btn-outline-secondary btn-plus">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">No. WhatsApp</label>
                            <input type="number" class="form-control" name="phone" required>
                            <small class="text-muted">
                                Format: Dimulai dengan 628 (contoh: 628123456789).
                                Jangan gunakan awalan +62 atau 0
                            </small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Rumah Sakit</label>
                            <input type="text" class="form-control" name="hospital" required 
                                   placeholder="Masukkan nama rumah sakit">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Diagnosis</label>
                            <input type="text" class="form-control" name="diagnosis" required 
                                   placeholder="Masukkan diagnosis">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Jenis Kelamin</label>
                            <select class="form-select" name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Pesan/Catatan</label>
                            <textarea class="form-control" name="message" 
                                     placeholder="Masukkan pesan atau catatan (opsional)"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 ps-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5>Data Wilayah</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Provinsi</label>
                            <select class="form-select" name="province_id" id="province_id" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Kabupaten/Kota</label>
                            <select class="form-select" name="city_id" id="city_id" required>
                                <option value="">Pilih Kabupaten/Kota</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Kecamatan</label>
                            <select class="form-select" name="district_id" id="district_id" required>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Desa/Kelurahan</label>
                            <select class="form-select" name="village_id" id="village_id" required>
                                <option value="">Pilih Desa/Kelurahan</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label required">Alamat</label>
                            <textarea class="form-control" name="address" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end col-12">
            <button type="submit" class="btn btn-primary">Submit Donor</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handler untuk tombol plus-minus jumlah kantong
    $(document).on('click', '.btn-plus', function() {
        let input = $(this).siblings('input[name="amount"]');
        input.val(parseInt(input.val()) + 1);
    });

    $(document).on('click', '.btn-minus', function() {
        let input = $(this).siblings('input[name="amount"]');
        let value = parseInt(input.val());
        if (value > 1) {
            input.val(value - 1);
        }
    });

    // Handler untuk dropdown wilayah
    $('#province_id').on('change', function() {
        var provinceId = $(this).val();
        $('#city_id').empty();
        $('#district_id').empty();
        $('#village_id').empty();

        if(provinceId) {
            $.get('/getCities/' + provinceId, function(cities) {
                $('#city_id').append('<option value="">Pilih Kota/Kabupaten</option>');
                $.each(cities, function(key, city) {
                    $('#city_id').append('<option value="'+ city.id +'">'+ city.name +'</option>');
                });
            });
        }
    });

    $('#city_id').on('change', function() {
        var cityId = $(this).val();
        $('#district_id').empty();
        $('#village_id').empty();

        if(cityId) {
            $.get('/getDistricts/' + cityId, function(districts) {
                $('#district_id').append('<option value="">Pilih Kecamatan</option>');
                $.each(districts, function(key, district) {
                    $('#district_id').append('<option value="'+ district.id +'">'+ district.name +'</option>');
                });
            });
        }
    });

    $('#district_id').on('change', function() {
        var districtId = $(this).val();
        $('#village_id').empty();

        if(districtId) {
            $.get('/getVillages/' + districtId, function(villages) {
                $('#village_id').append('<option value="">Pilih Desa/Kelurahan</option>');
                $.each(villages, function(key, village) {
                    $('#village_id').append('<option value="'+ village.id +'">'+ village.name +'</option>');
                });
            });
        }
    });
});
</script>
@endpush
