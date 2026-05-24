@extends('layouts.admin')

@section('content')

<h2 class="fw-bold mb-4">
    Data Memo
</h2>

@role('manager|direktur')
<a href="{{ route('memos.create') }}"
   class="btn btn-primary mb-3">

    Buat Memo

</a>
@endrole

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <table class="table">

            <tr>
                <th>Judul</th>
                <th>Tujuan</th>
                <th>dibuat oleh</th>
                <th>tanggal</th>
            </tr>

            @foreach($memos as $memo)

            <tr>

                <td>
                    <a href="{{ asset('storage/memos/' . $memo->file) }}"
                       target="_blank">

                        {{ $memo->title }}

                    </a>
                </td>

                <td>{{ $memo->message }}</td>

                <td>{{ $memo->sender?->name }}</td>

                <td>{{ $memo->created_at->format('d M Y') }}</td>

                <td>

                @if($memo->sender_id == auth()->id())

                <form action="{{ route('memos.destroy', $memo->id) }}"
                    method="POST"
                    class="d-inline">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-outline-danger btn-sm"
                    onclick="return confirm('Yakin ingin menghapus memo ini?')">
                        <i class="bi bi-trash"></i>
                    </button>

                </form>
                @endif

                </td>
            </tr>

            @endforeach

        </table>

    </div>

</div>

@endsection