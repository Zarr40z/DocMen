@extends('layouts.admin')

@section('content')

<h2 class="fw-bold mb-4">
    Notifications
</h2>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        @forelse($notifications as $notif)

            <div class="border-bottom p-3">

                {{ $notif->message }}

                <br>

                <small class="text-muted">
                    {{ $notif->created_at->diffForHumans() }}
                </small>

            </div>

        @empty

            <p>Tidak ada notifikasi.</p>

        @endforelse

    </div>

</div>

@endsection