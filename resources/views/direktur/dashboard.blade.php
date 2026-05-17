@extends('layouts.admin')

@section('content')

<h2 class="fw-bold mb-4">
    Dashboard Direktur
</h2>

<a href="{{ route('documents.index') }}"
   class="btn btn-primary">

    Lihat Dokumen Disposisi

</a>

@endsection