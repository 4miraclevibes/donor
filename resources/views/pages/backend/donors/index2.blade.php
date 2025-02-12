@extends('layouts.backend.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mt-2">
    <h5 class="card-header">Daftar Donor Darah</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Nama</th>
            <th class="text-white">Kategori</th>
            <th class="text-white">Gol. Darah</th>
            <th class="text-white">Jumlah</th>
            <th class="text-white">Lokasi</th>
            <th class="text-white">Status</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($donors as $donor)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>
              {{ $donor->user->name }}
              <br>
              <small class="text-muted">{{ $donor->phone }}</small>
            </td>
            <td>
              <span class="badge bg-{{ $donor->category ? 'success' : 'danger' }}">
                {{ $donor->category ? 'Mendonor' : 'Butuh Donor' }}
              </span>
            </td>
            <td>{{ $donor->golongan_darah }}</td>
            <td>{{ $donor->amount }} kantong</td>
            <td>
              {{ $donor->village->name }}, 
              {{ $donor->district->name }},
              <br>
              {{ $donor->city->name }},
              {{ $donor->province->name }}
            </td>
            <td>
              <span class="badge bg-{{ $donor->status == 'pending' ? 'warning' : ($donor->status == 'done' ? 'success' : 'danger') }}">
                {{ ucfirst($donor->status) }}
              </span>
            </td>
            <td>
              <div class="d-flex gap-1">
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $donor->id }}">
                  <i class="bx bx-show"></i>
                </button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $donor->id }}">
                  <i class="bx bx-edit"></i>
                </button>
                <a href="https://wa.me/{{ $donor->phone }}" 
                   class="btn btn-success btn-sm" 
                   target="_blank">
                  <i class="bx bxl-whatsapp"></i>
                </a>
                <form action="{{ route('donors.destroy', $donor->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    <i class="bx bx-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal View untuk setiap donor -->
@foreach ($donors as $donor)
<div class="modal fade" id="viewModal{{ $donor->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Donor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Data Pendonor -->
        <div class="mb-4">
          <table class="table table-bordered">
            <tr>
              <td style="width: 200px; background-color: #f8f9fa">NAMA</td>
              <td>{{ $donor->user->name }}</td>
            </tr>
            <tr>
              <td style="background-color: #f8f9fa">NO. WHATSAPP</td>
              <td>{{ $donor->phone }}</td>
            </tr>
            <tr>
              <td style="background-color: #f8f9fa">JENIS KELAMIN</td>
              <td>{{ $donor->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
              <td style="background-color: #f8f9fa">KATEGORI</td>
              <td>{{ $donor->category ? 'Mendonor' : 'Butuh Donor' }}</td>
            </tr>
            <tr>
              <td style="background-color: #f8f9fa">GOLONGAN DARAH</td>
              <td>{{ $donor->golongan_darah }}</td>
            </tr>
            <tr>
              <td style="background-color: #f8f9fa">JUMLAH KANTONG</td>
              <td>{{ $donor->amount }}</td>
            </tr>
          </table>
        </div>

        <!-- Data Medis & Lokasi -->
        <h6 class="fw-bold mb-3">Data Medis & Lokasi</h6>
        <table class="table table-bordered">
          <tr>
            <td style="width: 200px; background-color: #f8f9fa">RUMAH SAKIT</td>
            <td>{{ $donor->hospital }}</td>
          </tr>
          <tr>
            <td style="background-color: #f8f9fa">DIAGNOSIS</td>
            <td>{{ $donor->diagnosis }}</td>
          </tr>
          <tr>
            <td style="background-color: #f8f9fa">STATUS</td>
            <td>{{ ucfirst($donor->status) }}</td>
          </tr>
          <tr>
            <td style="background-color: #f8f9fa">ALAMAT</td>
            <td>{{ $donor->address }}</td>
          </tr>
          <tr>
            <td style="background-color: #f8f9fa">WILAYAH</td>
            <td>
              {{ $donor->village->name }}, 
              {{ $donor->district->name }},
              {{ $donor->city->name }},
              {{ $donor->province->name }}
            </td>
          </tr>
        </table>

        <!-- Pesan/Catatan -->
        @if($donor->message)
        <div class="mt-4">
          <h6 class="fw-bold mb-3">Pesan/Catatan</h6>
          <div class="p-3 bg-light rounded">
            {{ $donor->message }}
          </div>
        </div>
        @endif
      </div>
      <div class="modal-footer">
        <a href="https://wa.me/{{ $donor->phone }}" 
           class="btn btn-success" 
           target="_blank">
          <i class="bx bxl-whatsapp me-1"></i>
          Hubungi via WhatsApp
        </a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endforeach

<!-- Edit Modal untuk setiap donor -->
@foreach ($donors as $donor)
<div class="modal fade" id="editModal{{ $donor->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data Donor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('donors.update', $donor->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select class="form-select" name="category" required>
                  <option value="1" {{ $donor->category ? 'selected' : '' }}>Mendonor</option>
                  <option value="0" {{ !$donor->category ? 'selected' : '' }}>Butuh Donor</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Golongan Darah</label>
                <select class="form-select" name="golongan_darah" required>
                  @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $goldar)
                    <option value="{{ $goldar }}" {{ $donor->golongan_darah == $goldar ? 'selected' : '' }}>
                      {{ $goldar }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Jumlah Kantong</label>
                <input type="number" class="form-control" name="amount" value="{{ $donor->amount }}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">No. WhatsApp</label>
                <input type="text" class="form-control" name="phone" value="{{ $donor->phone }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Rumah Sakit</label>
                <input type="text" class="form-control" name="hospital" value="{{ $donor->hospital }}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Diagnosis</label>
                <input type="text" class="form-control" name="diagnosis" value="{{ $donor->diagnosis }}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="gender" required>
                  <option value="male" {{ $donor->gender == 'male' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="female" {{ $donor->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status" required>
                  <option value="pending" {{ $donor->status == 'pending' ? 'selected' : '' }}>Pending</option>
                  <option value="done" {{ $donor->status == 'done' ? 'selected' : '' }}>Done</option>
                  <option value="failed" {{ $donor->status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label">Pesan/Catatan</label>
                <textarea class="form-control" name="message" rows="3">{{ $donor->message }}</textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection

@push('styles')
<style>
.modal-lg {
    max-width: 800px;
}
.table td {
    vertical-align: middle;
}
.modal-body td {
    padding: 12px 15px;
}
.modal-body td:first-child {
    font-weight: 500;
    text-transform: uppercase;
    color: #566a7f;
}
</style>
@endpush