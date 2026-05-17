@extends('layouts.admin')

@section('content')

<h2 class="fw-bold mb-4">
    Dashboard Staff
</h2>

<div class="row">

    <div class="col-md-4">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h5>Total Dokumen</h5>

                <h2>
                    {{ \App\Models\Document::where('uploaded_by', auth()->id())->count() }}
                </h2>

            </div>

        </div>

    </div>

</div>

@endsection