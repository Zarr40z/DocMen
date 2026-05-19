@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold mb-0">
        Data User
    </h2>

    <a href="{{ route('users.create') }}"
       class="btn btn-primary rounded-3">

        <i class="bi bi-plus-lg"></i>

        Tambah User

    </a>

</div>

<div class="table-responsive">

    <table class="table table-hover align-middle">

        <thead class="table-light">

            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th width="180">Aksi</th>
            </tr>

        </thead>

        <tbody>

            @foreach($users as $user)

            <tr>

                <td class="fw-semibold">

                    {{ $user->name }}

                </td>

                <td>

                    {{ $user->email }}

                </td>

                <td>

                    <span class="badge bg-gray-800 text-dark">

                        {{ $user->roles->first()?->name }}

                    </span>

                </td>

                <td>

                    <a href="{{ route('users.edit', $user->id) }}"
                       class="btn btn-warning btn-sm rounded-3">
                        Edit
                    </a>

                    <form action="{{ route('users.destroy', $user->id) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm rounded-3">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection