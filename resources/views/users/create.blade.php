@extends('layouts.admin')

@section('content')

<h3 class="fw-bold mb-4">
    Tambah User
</h3>

<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <form action="{{ route('users.store') }}"
              method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Nama
                </label>

                <input type="text"
                       name="name"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <input type="password"
                       name="password"
                       class="form-control">

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Role
                </label>

                <select name="role"
                        class="form-select">

                    <option value="staff">Staff</option>
                    <option value="manager">Manager</option>
                    <option value="direktur">Direktur</option>
                    <option value="admin">Admin</option>    
                </select>
            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('users.index') }}"
               class="btn btn-light">
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection