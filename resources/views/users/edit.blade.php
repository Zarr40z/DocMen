@extends('layouts.admin')

@section('content')

<h3 class="fw-bold mb-4">
    Tambah User
</h3>

<form action="{{ route('users.update', $user->id) }}"
      method="POST">

    @csrf
    @method('PUT')

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
                       class="form-control"
                       value="{{ $user->name }}">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ $user->email }}">

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

                <select name="role" class="form-select">

                    <option value="staff"
                        {{ $user->roles->first()?->name == 'staff' ? 'selected' : '' }}>
                        Staff
                    </option>

                    <option value="manager"
                        {{ $user->roles->first()?->name == 'manager' ? 'selected' : '' }}>
                        Manager
                    </option>

                    <option value="direktur"
                        {{ $user->roles->first()?->name == 'direktur' ? 'selected' : '' }}>
                        Direktur
                    </option>

                    <option value="admin"
                        {{ $user->roles->first()?->name == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

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