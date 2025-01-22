@extends('layouts.frontend.main')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-md-12 text-center">
            <h2 class="fw-bold mb-3">Pengumuman Terbaru</h2>
            <p class="text-muted">Informasi dan pengumuman penting seputar donor darah</p>
        </div>
    </div>

    <!-- Announcements Grid -->
    <div class="row g-4">
        @forelse($announcements as $announcement)
            @if($announcement->status)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($announcement->thumbnail)
                            <img src="{{ asset('storage/' . $announcement->thumbnail) }}" 
                                class="card-img-top" 
                                alt="Thumbnail"
                                style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                style="height: 200px;">
                                <i class="bx bx-image text-secondary" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="bx bx-calendar me-1"></i>
                                    {{ $announcement->created_at->format('d M Y') }}
                                </small>
                                <small class="text-muted">
                                    <i class="bx bx-user me-1"></i>
                                    {{ $announcement->user->name }}
                                </small>
                            </div>
                            
                            <h5 class="card-title fw-bold mb-3">{{ $announcement->title }}</h5>
                            
                            <p class="card-text text-muted mb-3">
                                {{ Str::limit(strip_tags($announcement->content), 100) }}
                            </p>
                            
                            <button type="button" 
                                class="btn btn-outline-primary btn-sm"
                                data-bs-toggle="modal" 
                                data-bs-target="#announcementModal{{ $announcement->id }}">
                                <i class="bx bx-book-reader me-1"></i>
                                Baca Selengkapnya
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="announcementModal{{ $announcement->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold">{{ $announcement->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($announcement->thumbnail)
                                    <img src="{{ asset('storage/' . $announcement->thumbnail) }}" 
                                        class="img-fluid rounded mb-4" 
                                        alt="Thumbnail">
                                @endif
                                
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-muted">
                                        <i class="bx bx-calendar me-1"></i>
                                        {{ $announcement->created_at->format('d M Y, H:i') }}
                                    </span>
                                    <span class="text-muted">
                                        <i class="bx bx-user me-1"></i>
                                        {{ $announcement->user->name }}
                                    </span>
                                </div>

                                <div class="content">
                                    {!! nl2br(e($announcement->content)) !!}
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="col-12 text-center py-5">
                <i class="bx bx-news text-secondary mb-3" style="font-size: 4rem;"></i>
                <h5 class="text-secondary">Belum ada pengumuman</h5>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .content {
        line-height: 1.8;
        color: #444;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .container {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }
        
        .card-img-top {
            height: 180px !important;
        }
    }
</style>
@endpush