<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocMen</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">

    <style>

        body{
            background:#f5f7fb;
            font-family:'Plus Jakarta Sans', sans-serif;
        }

        .sidebar{
            min-height:100vh;
            background:#ffffff;
            border-right:1px solid #e5e7eb;
        }

        .sidebar .nav-link{
            color:#374151;
            border-radius:12px;
            padding:12px 14px;
            font-weight:500;
            transition:0.2s;
        }

        .sidebar .nav-link:hover{
            background:#eef2ff;
            color:#4f46e5;
        }

        .sidebar .nav-link.active{
            background:#4f46e5;
            color:white;
        }

        .content-wrapper{
            padding:30px;
        }

        .content-card{
            background:white;
            border-radius:20px;
            padding:25px;
            box-shadow:0 2px 10px rgba(0,0,0,0.2);
        }

        .logo-text{
            color:#4f46e5;
            font-weight:700;
        }

        .btn-primary{
            background:#4f46e5;
            border:none;
        }

        .btn-primary:hover{
            background:#4338ca;
        }

        .table{
            margin-bottom:0;
        }

        @media(max-width:768px){

            .sidebar{
                min-height:auto;
            }

            .content-wrapper{
                padding:15px;
            }
        }

    </style>

</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-0">

            <div class="p-4 border-bottom">

                <h3 class="logo-text mb-0">
                    DocMen
                </h3>

            </div>

            <ul class="nav flex-column p-3">

                @role('admin')
                <li class="nav-item mb-2">
                    <a href="/admin/dashboard"
                       class="nav-link">
                        <i class="bi bi-grid me-2"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="/users"
                       class="nav-link">
                        <i class="bi bi-people me-2"></i>
                        Kelola User
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('document-logs.index') }}"
                       class="nav-link">
                        <i class="bi bi-clock-history me-2"></i>
                        Log Aktivitas
                    </a>
                </li>
                @endrole

                @role('staff')
                <li class="nav-item mb-2">
                    <a href="/staff/dashboard"
                       class="nav-link">
                        <i class="bi bi-grid me-2"></i>
                        Dashboard
                    </a>
                </li>
                @endrole

                @role('manager')
                <li class="nav-item mb-2">
                    <a href="/manager/dashboard"
                       class="nav-link">
                        <i class="bi bi-grid me-2"></i>
                        Dashboard
                    </a>
                </li>
                @endrole

                @role('direktur')
                <li class="nav-item mb-2">
                    <a href="/direktur/dashboard"
                       class="nav-link">
                        <i class="bi bi-grid me-2"></i>
                        Dashboard
                    </a>
                </li>
                @endrole

                @role('manager|direktur|staff')
                <li class="nav-item mb-2">
                    <a href="/documents"
                       class="nav-link">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Dokumen
                    </a>
                </li>

                @endrole

                <li class="nav-item mb-2">
                    <a href="{{ route('memos.index') }}"
                       class="nav-link">
                        <i class="bi bi-envelope me-2"></i>
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
                       class="nav-link">
                        <i class="bi bi-bell me-2"></i>
                        Notifications
                        @if($notifCount > 0)
                        <span class="badge bg-danger ms-2">
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
        <div class="col-md-10 content-wrapper">

            <div class="content-card">

                @yield('content')

            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>