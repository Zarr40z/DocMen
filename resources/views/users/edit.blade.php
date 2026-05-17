<h1>Edit User</h1>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Nama</label>
        <input type="text" name="name" value="{{ $user->name }}">
    </div>

    <br>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}">
    </div>

    <br>

    <div>
        <label>Role</label>

        <select name="role">

            @foreach($roles as $role)

                <option
                    value="{{ $role->name }}"
                    {{ $user->roles->first()->name == $role->name ? 'selected' : '' }}
                >
                    {{ $role->name }}
                </option>

            @endforeach

        </select>
    </div>

    <br>

    <button type="submit">
        Update
    </button>

</form>