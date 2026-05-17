<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocMen</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f5f6fa;">

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar ---------------------------------------------------------------------------->
        <div class="col-md-2 bg-dark text-white min-vh-100 p-0">

            <div class="p-3 border-bottom">
                <h2 class="fw-bold">DocMen</h2>
            </div>

            <ul class="nav flex-column p-3">

                @role('admin')
                <li class="nav-item mb-2">
                    <a href="/admin/dashboard"
                    class="nav-link text-white">

                        Dashboard

                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="/users"
                       class="nav-link text-white">
                        Kelola User
                    </a>
                </li>
                
                <li class="nav-item mb-2">
                    <a href="{{ route('document.logs') }}"
                       class="nav-link text-white">
                        Log Aktivitas
                    </a>

                @endrole

                @role('staff')
                <li class="nav-item mb-2">
                    <a href="/staff/dashboard"
                    class="nav-link text-white">

                        Dashboard

                    </a>
                </li>
                @endrole

                @role('manager')
                <li class="nav-item mb-2">
                    <a href="/manager/dashboard"
                    class="nav-link text-white">

                        Dashboard

                    </a>
                </li>
                @endrole

                @role('direktur')
                <li class="nav-item mb-2">
                    <a href="/direktur/dashboard"
                    class="nav-link text-white">

                        Dashboard

                    </a>
                </li>
                @endrole

                @role('manager|direktur|staff')
                <li class="nav-item mb-2">
                    <a href="/documents"
                       class="nav-link text-white">
                        Dokumen
                    </a>
                </li>
                @endrole
                
                <li class="nav-item mb-2">
                    <a href="{{ route('memos.index') }}"
                       class="nav-link text-white">
                        Memo
                    </a>
                </li>

                @php
                $notifCount = \App\Models\Notification::where(
                    'user_id',
                    auth()->id()
                )->where('is_read', false)->count();

                @endphp

                <li class="nav-item mb-2">

                    <a href="{{ route('notifications.index') }}"
                    class="nav-link text-white">

                        Notifications

                        @if($notifCount > 0)

                            <span class="badge bg-danger">
                                {{ $notifCount }}
                            </span>

                        @endif

                    </a>

                </li>

                <li class="nav-item mt-4">
                    <form method="POST"
                          action="{{ route('logout') }}">

                        @csrf

                        <button class="btn btn-danger w-100">
                            Logout
                        </button>

                    </form>
                </li>

            </ul>

        </div>

        <!-- Content -->
        <div class="col-md-10 p-4">

            <div class="bg-white shadow-sm rounded p-4">

                @yield('content')

            </div>

        </div>

    </div>
</div>

</body>
</html>