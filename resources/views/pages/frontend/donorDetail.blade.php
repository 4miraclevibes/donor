@extends('layouts.frontend.main')

@section('content')
<div class="container py-5">
    <!-- Donor Information -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Donor</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150">Status</td>
                            <td>: 
                                <span class="badge bg-{{ $donor->status == 'pending' ? 'warning' : ($donor->status == 'done' ? 'success' : 'danger') }}">
                                    {{ ucfirst($donor->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>: 
                                <span class="badge bg-{{ $donor->category ? 'success' : 'danger' }}">
                                    {{ $donor->category ? 'Mendonor' : 'Butuh Donor' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Golongan Darah</td>
                            <td>: {{ $donor->golongan_darah }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Kantong</td>
                            <td>: {{ $donor->amount }}</td>
                        </tr>
                        <tr>
                            <td>No. WhatsApp</td>
                            <td class="d-flex align-items-center gap-2">
                                : {{ $donor->phone }}
                                <a href="https://wa.me/{{ $donor->phone }}" 
                                   class="btn btn-success btn-sm"
                                   target="_blank">
                                    <i class="bx bx-message-rounded-dots me-1"></i>
                                    Chat WA
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150">Provinsi</td>
                            <td>: {{ $donor->province->name }}</td>
                        </tr>
                        <tr>
                            <td>Kota/Kabupaten</td>
                            <td>: {{ $donor->city->name }}</td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>: {{ $donor->district->name }}</td>
                        </tr>
                        <tr>
                            <td>Desa/Kelurahan</td>
                            <td>: {{ $donor->village->name }}</td>
                        </tr>
                        <tr>
                            <td>Alamat Lengkap</td>
                            <td>: {{ $donor->address }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @if($donor->message)
                <div class="alert alert-info mt-3">
                    <i class="bx bx-info-circle me-2"></i>{{ $donor->message }}
                </div>
            @endif
        </div>
    </div>

    <!-- Form Entry -->
    @if($donor->status == 'pending')
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Keterangan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('donor.detail.store', $donor->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pesan/Keterangan</label>
                        <textarea name="message" class="form-control" rows="3" required 
                            placeholder="Tuliskan pesan atau keterangan tambahan..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="address" class="form-control" required
                            placeholder="Masukkan alamat lengkap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <div class="input-group">
                            <input type="text" name="phone" class="form-control" required
                                placeholder="Contoh: 628123456789" 
                                pattern="^628\d{8,11}$"
                                title="Nomor telepon harus diawali dengan 628 dan terdiri dari 10-13 digit">
                            <span class="input-group-text bg-light text-muted">
                                <i class="bx bx-info-circle"></i>
                            </span>
                        </div>
                        <div class="form-text text-muted">
                            <i class="bx bx-info-circle me-1"></i>
                            Format: Diawali dengan 628 (Contoh: 628123456789)
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i>Simpan Keterangan
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Donor Details History -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Riwayat Keterangan</h5>
        </div>
        <div class="card-body">
            @if($donor->details->count() > 0)
                <div class="timeline">
                    @foreach($donor->details->sortByDesc('created_at') as $detail)
                        <div class="timeline-item pb-4">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-{{ 
                                    $detail->status == 'done' ? 'success' : 
                                    ($detail->status == 'pending' ? 'warning' : 'danger') 
                                }} me-2">
                                    {{ ucfirst($detail->status) }}
                                </span>
                                
                                <!-- Tombol Update Status hanya untuk pemilik donor dan status masih pending -->
                                @if(Auth::id() == $donor->user_id && $detail->status == 'pending')
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="{{ route('donor.detail.update-status', $detail->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="done">
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-check me-1"></i>Selesai
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('donor.detail.update-status', $detail->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="failed">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times me-1"></i>Gagal
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                <small class="text-muted ms-2">
                                    <i class="bx bx-time-five me-1"></i>
                                    {{ $detail->created_at->format('d M Y H:i') }}
                                </small>
                                <small class="text-muted ms-2">
                                    <i class="bx bx-user me-1"></i>
                                    {{ $detail->user->name }}
                                </small>
                            </div>
                            <div class="ps-3 border-start">
                                <p class="mb-1">{{ $detail->message }}</p>
                                <small class="text-muted d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bx bx-map-pin me-1"></i>{{ $detail->address }}<br>
                                        <i class="bx bx-phone me-1"></i>{{ $detail->phone }}
                                    </div>
                                    <a href="https://wa.me/{{ $detail->phone }}" 
                                       class="btn btn-success btn-sm ms-2"
                                       target="_blank">
                                        <i class="bx bx-message-rounded-dots me-1"></i>
                                        Chat WA
                                    </a>
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bx bx-info-circle text-muted mb-2" style="font-size: 2rem;"></i>
                    <p class="text-muted mb-0">Belum ada riwayat keterangan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline-item:not(:last-child) {
        border-bottom: 1px dashed #dee2e6;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0 !important;
    }
</style>
@endpush