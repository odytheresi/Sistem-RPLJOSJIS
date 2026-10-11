@extends('layouts.operator')

@section('title', 'Tambah Charging Station')

@section('content')
<div class="container-fluid py-3">
    <h4 class="mb-3">Tambah Charging Station</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('operator.station._form', [
                'action'      => route('operator.station.store'),
                'submitLabel' => 'Simpan station',
            ])
        </div>
    </div>
</div>
@endsection