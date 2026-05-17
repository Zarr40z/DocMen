@extends('layouts.admin')

@section('content')

<h2 class="fw-bold mb-4">
    Dashboard Manager
</h2>

<a href="{{ route('documents.index') }}"
   class="btn btn-primary">
    Lihat Dokumen
</a>

@endsection