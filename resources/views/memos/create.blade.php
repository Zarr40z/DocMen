@extends('layouts.admin')

@section('content')

@if ($errors->any())

<div class="alert alert-danger">

    <ul class="mb-0">

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('memos.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <div class="mb-3">

        <label>Upload Memo</label>

        <input type="file"
               name="file"
               class="form-control">

    </div>

    <div class="mb-3">

        <label>Tujuan Singkat</label>

        <input type="text"
               name="tujuan"
               class="form-control">

    </div>

    <div class="mb-3">

        <label>Kirim ke Divisi</label>

        <select name="target_role"
                class="form-control">

            <option value="staff">Staff</option>
            <option value="admin">Admin</option>
            @role('direktur')
            <option value="manager">Manager</option>
            @endrole
        </select>

    </div>

    <button class="btn btn-primary">

        Upload

    </button>

</form>
@endsection