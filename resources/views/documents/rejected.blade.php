@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">Dokumen Ditolak</h2>

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

                    @elseif($document->status == 'pending_director')
                    <span class="badge bg-primary">
                        Pending Direktur
                    </span>

                    @elseif($document->status == 'approved_manager')
                    <span class="badge bg-success">
                        Approved Manager
                    </span>

                    @elseif($document->status == 'approved_final')
                    <span class="badge bg-success">
                        Approved Final
                    </span>

                    @elseif($document->status == 'rejected_manager')
                    <span class="badge bg-danger">
                        Rejected Manager
                    </span>

                    @elseif($document->status == 'rejected_final')
                    <span class="badge bg-danger">
                        Rejected Final
                    </span>

                    @endif

                    </td>

                    <td>

                        {{ $document->created_at->format('d M Y') }}

                    </td>
                    
                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection