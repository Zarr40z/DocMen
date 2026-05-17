<h1>Tambah User</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <div>
        <label>Nama</label>
        <input type="text" name="name">
    </div>

    <br>

    <div>
        <label>Email</label>
        <input type="email" name="email">
    </div>

    <br>

    <div>
        <label>Password</label>
        <input type="password" name="password">
    </div>

    <br>

    <div>
        <label>Role</label>

        <select name="role">
            @foreach($roles as $role)
                <option value="{{ $role->name }}">
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <button type="submit">
        Simpan
    </button>

</form>