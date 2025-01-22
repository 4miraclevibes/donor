@extends('layouts.backend.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
        <i class="fas fa-plus me-2"></i>Tambah Pengumuman
      </button>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Daftar Pengumuman</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Thumbnail</th>
            <th class="text-white">Judul</th>
            <th class="text-white">Status</th>
            <th class="text-white">Dibuat Oleh</th>
            <th class="text-white">Tanggal</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($announcements as $announcement)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>
              @if($announcement->thumbnail)
                <img src="{{ asset('storage/' . $announcement->thumbnail) }}" alt="Thumbnail" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
              @else
                <span class="badge bg-secondary">No Image</span>
              @endif
            </td>
            <td>{{ $announcement->title }}</td>
            <td>
              <span class="badge bg-{{ $announcement->status ? 'success' : 'danger' }}">
                {{ $announcement->status ? 'Published' : 'Draft' }}
              </span>
            </td>
            <td>{{ $announcement->user->name }}</td>
            <td>{{ $announcement->created_at->format('d M Y') }}</td>
            <td>
              <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $announcement->id }}">
                <i class="bx bx-show"></i>
              </button>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $announcement->id }}">
                <i class="bx bx-edit"></i>
              </button>
              <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                  <i class="bx bx-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pengumuman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" class="form-control" name="title" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Thumbnail</label>
            <input type="file" class="form-control" name="thumbnail" accept="image/*">
          </div>
          <div class="mb-3">
            <label class="form-label">Konten</label>
            <textarea class="form-control" name="content" rows="5" required></textarea>
          </div>
          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="status" value="1" id="statusCheck">
              <label class="form-check-label" for="statusCheck">
                Publish sekarang
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
@foreach($announcements as $announcement)
<div class="modal fade" id="editModal{{ $announcement->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Pengumuman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" class="form-control" name="title" value="{{ $announcement->title }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Thumbnail</label>
            @if($announcement->thumbnail)
              <div class="mb-2">
                <img src="{{ asset('storage/' . $announcement->thumbnail) }}" alt="Current Thumbnail" class="rounded" style="max-width: 200px;">
              </div>
            @endif
            <input type="file" class="form-control" name="thumbnail" accept="image/*">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah thumbnail</small>
          </div>
          <div class="mb-3">
            <label class="form-label">Konten</label>
            <textarea class="form-control" name="content" rows="5" required>{{ $announcement->content }}</textarea>
          </div>
          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="status" value="1" id="statusCheckEdit{{ $announcement->id }}" {{ $announcement->status ? 'checked' : '' }}>
              <label class="form-check-label" for="statusCheckEdit{{ $announcement->id }}">
                Publish
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal{{ $announcement->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $announcement->title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if($announcement->thumbnail)
          <img src="{{ asset('storage/' . $announcement->thumbnail) }}" alt="Thumbnail" class="img-fluid rounded mb-3">
        @endif
        <div class="mb-3">
          {!! nl2br(e($announcement->content)) !!}
        </div>
        <small class="text-muted">
          Dibuat oleh: {{ $announcement->user->name }} | 
          {{ $announcement->created_at->format('d M Y H:i') }}
        </small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
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
</style>
@endpush