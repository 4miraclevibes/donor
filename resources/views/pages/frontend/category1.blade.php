@extends('layouts.frontend.main')

@section('content')
<div class="container content py-5">
    <div class="row mb-5">
        <div class="col-md-12 text-center">
            <h2 class="fw-bold mb-3">Daftar Pendonor Darah</h2>
            <p class="text-muted">Berikut adalah daftar orang yang ingin mendonorkan darah. Silakan hubungi pendonor yang sesuai dengan kebutuhan Anda.</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('category1') }}" method="GET" class="row g-3">
                        <!-- Filter Golongan Darah -->
                        <div class="col-md-2">
                            <label class="form-label">Golongan Darah</label>
                            <select name="golongan_darah" class="form-select">
                                <option value="">Semua Golongan</option>
                                <option value="A+" {{ request('golongan_darah') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ request('golongan_darah') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ request('golongan_darah') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ request('golongan_darah') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ request('golongan_darah') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ request('golongan_darah') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ request('golongan_darah') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ request('golongan_darah') == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                        </div>

                        <!-- Filter Provinsi -->
                        <div class="col-md-2">
                            <label class="form-label">Provinsi</label>
                            <select name="province_id" class="form-select" id="province">
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Kota -->
                        <div class="col-md-3">
                            <label class="form-label">Kota/Kabupaten</label>
                            <select name="city_id" class="form-select" id="city">
                                <option value="">Pilih Kota/Kabupaten</option>
                            </select>
                        </div>

                        <!-- Filter Kecamatan -->
                        <div class="col-md-3">
                            <label class="form-label">Kecamatan</label>
                            <select name="district_id" class="form-select" id="district">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>

                        <!-- Tombol Filter -->
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($donors as $donor)
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">{{ $donor->user->name }}</h5>
                            <div>
                                <span class="badge bg-light text-primary me-2">
                                    Golongan {{ $donor->golongan_darah }}
                                </span>
                                <span class="badge {{ $donor->status == 'pending' ? 'bg-warning' : ($donor->status == 'done' ? 'bg-success' : 'bg-danger') }}">
                                    {{ ucfirst($donor->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Lokasi</small>
                                        <strong>{{ $donor->village->name }}, {{ $donor->district->name }}</strong>
                                        <p class="text-muted mb-0">{{ $donor->city->name }}, {{ $donor->province->name }}</p>
                                        @if($donor->address)
                                            <p class="text-muted mb-0 mt-1">
                                                <i class="fas fa-home text-secondary me-1"></i>
                                                {{ $donor->address }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @if($donor->hospital || $donor->diagnosis)
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-hospital text-info me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Informasi Medis</small>
                                        @if($donor->hospital)
                                            <strong class="d-block">{{ $donor->hospital }}</strong>
                                        @endif
                                        @if($donor->diagnosis)
                                            <p class="text-muted mb-0">{{ $donor->diagnosis }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tint text-danger me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Jumlah Kantong</small>
                                        <strong>{{ $donor->amount }} kantong</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Jenis Kelamin</small>
                                        <strong>{{ $donor->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-phone text-success me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Kontak</small>
                                        <strong>{{ $donor->phone }}</strong>
                                    </div>
                                </div>
                            </div>

                            @if($donor->message)
                            <div class="col-12">
                                <div class="alert alert-light border">
                                    <i class="fas fa-quote-left text-muted me-2"></i>
                                    {{ $donor->message }}
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <a href="{{ route('donor.detail', $donor->id) }}" 
                               class="btn btn-primary flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                                <i class="bx bx-info-circle"></i>
                                Lihat Detail
                            </a>
                            <a href="https://wa.me/{{ $donor->phone }}" 
                               class="btn btn-success flex-grow-1 d-flex align-items-center justify-content-center gap-2" 
                               target="_blank">
                                <i class="fab fa-whatsapp"></i>
                                Hubungi via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-info d-flex align-items-center" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <div>
                        Belum ada pendonor yang terdaftar saat ini.
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col-md-12 d-flex justify-content-center">
            {{ $donors->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .badge {
        font-size: 0.9rem;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Load data awal
    var selectedProvinceId = $('#province').val();
    var selectedCityId = '{{ request('city_id') }}';
    var selectedDistrictId = '{{ request('district_id') }}';
    
    // Load kota jika provinsi sudah terpilih
    if(selectedProvinceId) {
        $.get('/getCities/' + selectedProvinceId, function(cities) {
            $('#city').empty();
            $('#city').append('<option value="">Pilih Kota/Kabupaten</option>');
            $.each(cities, function(key, city) {
                var selected = (city.id == selectedCityId) ? 'selected' : '';
                $('#city').append('<option value="'+ city.id +'" '+ selected +'>'+ city.name +'</option>');
            });
            
            // Load kecamatan jika kota sudah terpilih
            if(selectedCityId) {
                $.get('/getDistricts/' + selectedCityId, function(districts) {
                    $('#district').empty();
                    $('#district').append('<option value="">Pilih Kecamatan</option>');
                    $.each(districts, function(key, district) {
                        var selected = (district.id == selectedDistrictId) ? 'selected' : '';
                        $('#district').append('<option value="'+ district.id +'" '+ selected +'>'+ district.name +'</option>');
                    });
                });
            }
        });
    }

    // Handler untuk perubahan provinsi
    $('#province').on('change', function() {
        var provinceId = $(this).val();
        $('#city').empty();
        $('#district').empty();
        
        if(provinceId) {
            $.get('/getCities/' + provinceId, function(cities) {
                $('#city').append('<option value="">Pilih Kota/Kabupaten</option>');
                $.each(cities, function(key, city) {
                    $('#city').append('<option value="'+ city.id +'">'+ city.name +'</option>');
                });
            });
        } else {
            $('#city').append('<option value="">Pilih Kota/Kabupaten</option>');
            $('#district').append('<option value="">Pilih Kecamatan</option>');
        }
    });

    // Handler untuk perubahan kota
    $('#city').on('change', function() {
        var cityId = $(this).val();
        $('#district').empty();
        
        if(cityId) {
            $.get('/getDistricts/' + cityId, function(districts) {
                $('#district').append('<option value="">Pilih Kecamatan</option>');
                $.each(districts, function(key, district) {
                    $('#district').append('<option value="'+ district.id +'">'+ district.name +'</option>');
                });
            });
        } else {
            $('#district').append('<option value="">Pilih Kecamatan</option>');
        }
    });
});
</script>
@endpush
