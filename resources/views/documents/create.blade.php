@extends('layouts.admin')

@section('content')

<h2 class="fw-bold mb-4">
    Upload Dokumen
</h2>

@if ($errors->any())

<div class="alert alert-danger">

    {{ $errors->first() }}

</div>

@endif

<div class="card border-0 shadow-sm">

    <div class="card-body">

        

        <form action="{{ route('documents.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-3">

                <label class="form-label">

                    Upload Dokumen

                </label>

                <input type="file"
                       name="file"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Tujuan Singkat

                </label>

                <input type="text"
                       name="tujuan"
                       class="form-control"
                       placeholder="Contoh: Pengajuan cuti">

            </div>

            <button class="btn btn-primary">

                Upload

            </button>

        </form>

    </div>

</div>

@endsection