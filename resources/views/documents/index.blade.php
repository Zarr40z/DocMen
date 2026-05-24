@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">Dokumen</h2>

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
                    
                    @role('staff|manager|direktur')
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
                    
                    <td>{{ $document->tujuan }}</td>
                    <td>{{ $document->user?->name }}</td>

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

                    @role('staff')

                    <td>

                    @if(
                        auth()->id() == $document->uploaded_by
                        &&
                        $document->status == 'pending_manager'
                    )

                    <form action="{{ route('documents.destroy', $document->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-outline-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus dokumen ini?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>

                    @endif

                    </td>

                    @endrole

                @role('manager')

                <td class="d-flex gap-1">

                    <form action="{{ route('documents.update', $document->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('PUT')

                        <button
                            name="action"
                            value="approve"
                            class="btn btn-success btn-sm">
                            Approve
                        </button>
                    </form>

                    <form action="{{ route('documents.update', $document->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('PUT')

                        <button
                            name="action"
                            value="reject"
                            class="btn btn-danger btn-sm">
                            Reject
                        </button>
                    </form>

                    <form action="{{ route('documents.update', $document->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('PUT')

                        <button
                            name="action"
                            value="disposisi"
                            class="btn btn-primary btn-sm">
                            Disposisi
                        </button>
                    </form>
                </td>
                @endrole


                @role('direktur')

                <td class="d-flex gap-1">

                    <form action="{{ route('documents.update', $document->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('PUT')

                        <button
                            name="action"
                            value="approve"
                            class="btn btn-success btn-sm">
                            Final Approve
                        </button>
                    </form>

                    <form action="{{ route('documents.update', $document->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('PUT')

                        <button
                            name="action"
                            value="reject"
                            class="btn btn-danger btn-sm">
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