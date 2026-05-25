@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold mb-0">
        Notifications
    </h2>

    @if($notifications->count() > 0)

    <form action="{{ route('notifications.deleteAll') }}"
          method="POST">

        @csrf
        @method('DELETE')

        <button class="btn btn-danger btn-sm"
        onclick="return confirm('Apakah Anda ingin menghapus semua notifikasi?')">

            <i class="bi bi-trash"></i>
            Hapus Semua

        </button>

    </form>

    @endif

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        @forelse($notifications as $notif)

        <div class="border-bottom p-3">

            <div class="row align-items-center">

                <div class="col-md-9">

                    <div>

                        {{ $notif->message }}

                    </div>

                    <small class="text-muted">

                        {{ $notif->created_at->diffForHumans() }}

                    </small>

                </div>

                <div class="col-md-3 text-end d-flex justify-content-end gap-2">

                    @if($notif->link)

                    <a href="{{ $notif->link }}"
                       class="btn btn-primary btn-sm">
                        Buka
                    </a>

                    @endif

                    <form action="{{ route('notifications.destroy', $notif->id) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Hapus notifikasi ini?')">
                            Hapus
                        </button>

                    </form>

                </div>

            </div>

        </div>

        @empty

        <p class="text-muted mb-0">
            Tidak ada notifikasi.
        </p>

        @endforelse

    </div>

</div>

@endsection