@extends('layouts.admin')

@section('content')

<h2 class="fw-bold mb-4">
    Log Aktivitas
</h2>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <table class="table">

            <tr>
                <th>User</th>
                <th>Aktivitas</th>
                <th>dokumen</th>
                <th>Waktu</th>
            </tr>

            @foreach($logs as $log)

            <tr>

                <td>{{ $log->user->name ?? '-' }}</td>

                <td>{{ $log->activity }}</td>

                <td>{{ $log->document->judul ?? '-' }}</td>

                <td>{{ $log->created_at }}</td>

            </tr>

            @endforeach

        </table>

    </div>

</div>

@endsection