@extends('layouts.admin')

@section('content')

<h2 class="fw-bold mb-4">
    Dashboard
</h2>

<div class="row">

    <div class="col-md-4 mb-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h5>Total User</h5>

                <h2>
                    {{ \App\Models\User::count() }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4 mb-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h5>Total Dokumen</h5>

                <h2>
                    {{ \App\Models\Document::count() }}
                </h2>

            </div>

        </div>

    </div>
    <div class="col-md-4 mb-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h5>Total Memo</h5>

                <h2>
                    {{ \App\Models\Memo::count() }}
                </h2>

            </div>

        </div>

    </div>

</div>

@endsection