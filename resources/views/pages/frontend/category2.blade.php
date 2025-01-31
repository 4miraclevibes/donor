@extends('layouts.frontend.main')

@section('content')
<div class="container content py-5">
    <div class="row mb-5">
        <div class="col-md-12 text-center">
            <h2 class="fw-bold mb-3">Daftar Pendonor Darah</h2>
            <p class="text-muted">Berikut adalah daftar orang yang ingin mendonorkan darah. Silakan hubungi pendonor yang sesuai dengan kebutuhan Anda.</p>
        </div>
    </div>

    <!-- Info Card Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body d-flex align-items-center justify-content-between py-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-tint fa-3x me-3"></i>
                        <div>
                            <h6 class="mb-0">Total Kantong Darah Tersedia</h6>
                            <h2 class="mb-0 fw-bold">{{ $donors->where('category', true)->where('status', 'pending')->sum('amount') }} Kantong</h2>
                        </div>
                    </div>
                    <div>
                        <span class="badge bg-white text-primary fs-6">Status: Aktif</span>
                    </div>
                </div>
            </div>
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

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="donorsTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Golongan Darah</th>
                            <th>Lokasi</th>
                            <th>Jumlah Kantong</th>
                            <th>Status</th>
                            <th>Kontak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donors as $donor)
                        <tr>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $donor->fullname ?? $donor->user->name }}</span>
                                    <small class="text-muted">{{ $donor->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $donor->golongan_darah }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span>{{ $donor->village->name }}, {{ $donor->district->name }}</span>
                                    <small class="text-muted">{{ $donor->city->name }}, {{ $donor->province->name }}</small>
                                </div>
                            </td>
                            <td>{{ $donor->amount }} kantong</td>
                            <td>
                                <span class="badge {{ $donor->status == 'pending' ? 'bg-warning' : ($donor->status == 'done' ? 'bg-success' : 'bg-danger') }}">
                                    {{ ucfirst($donor->status) }}
                                </span>
                            </td>
                            <td>{{ $donor->phone }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('donor.detail', $donor->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="https://wa.me/{{ $donor->phone }}" 
                                       class="btn btn-sm btn-success"
                                       target="_blank">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    .badge {
        font-size: 0.9rem;
    }
    .fa-tint {
        filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.2));
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
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

    $('#donorsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
        },
        order: [[4, 'asc']], // Urutkan berdasarkan status
        columnDefs: [
            {
                targets: -1,
                orderable: false // Kolom aksi tidak bisa diurutkan
            }
        ],
        pageLength: 10,
        responsive: true
    });
});
</script>
@endpush
