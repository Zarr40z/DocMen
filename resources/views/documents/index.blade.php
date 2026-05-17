@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">Data Dokumen</h2>

    @role('staff|manager')
<a href="{{ route('documents.create') }}"
   class="btn btn-primary">
    Upload Dokumen
</a>
    @endrole
</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <table class="table table-hover align-middle">

            <thead class="table-light">

                <tr>
                    <th>Judul Dokumen</th>
                    <th>Tujuan</th>
                    <th>Dibuat Oleh</th>
                    <th>Status</th>
                    <th>Tanggal</th>

                    {{--Untuk keputusan manager dan direktur --}}
                    @role('manager|direktur')
                    <th>Aksi</th>
                    @endrole

                </tr>

            </thead>

            <tbody>

                @foreach($documents as $document)

                <tr>

                     <td>

                        <a href="{{ asset('storage/documents/' . $document->file) }}"
                            target="_blank">

                            {{ $document->judul }}
                        </a>
                    </td>
                    <td>

                        {{ $document->tujuan }}

                    </td>

                    <td>

                       {{ $document->user?->name }}

                    </td>

                    <td>

                    @if($document->status == 'pending_manager')

                    <span class="badge bg-warning">

                        Pending Manager

                    </span>

                     @elseif($document->status == 'approved')

                    <span class="badge bg-success">

                        Approved

                    </span>

                     @elseif($document->status == 'rejected')

                    <span class="badge bg-danger">

                        Rejected

                    </span>

                    @elseif($document->status == 'disposisi')

                    <span class="badge bg-warning">

                    Disposisi Direktur

                    </span>

                    @endif

                    </td>

                    <td>

                        {{ $document->created_at->format('d M Y') }}

                    </td>

                    @role('manager')

                    <td>

                        <form action="{{ route('documents.approve', $document->id) }}"
                            method="POST"
                            class="d-inline">

                    @csrf

                    <button class="btn btn-success btn-sm">

                        Approve

                    </button>

                    </form>

                <form action="{{ route('documents.reject', $document->id) }}"
                    method="POST"
                    class="d-inline">

                 @csrf

                <button class="btn btn-danger btn-sm">

                    Reject

                </button>

                </form>

                <form action="{{ route('documents.disposisi', $document->id) }}"
                    method="POST"
                    class="d-inline">

                @csrf

                <button class="btn btn-primary btn-sm">

                    Disposisi

                </button>

                </form>

            </td>

                @endrole

                 @role('direktur')

            <td>

                <form action="{{ route('documents.finalApprove', $document->id) }}"
                    method="POST"
                    class="d-inline">

            @csrf

            <button class="btn btn-success btn-sm">

                Final Approve

            </button>

        </form>

        <form action="{{ route('documents.reject', $document->id) }}"
              method="POST"
              class="d-inline">

            @csrf

            <button class="btn btn-danger btn-sm">

                Reject

            </button>

        </form>

        </td>

        @endrole

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection