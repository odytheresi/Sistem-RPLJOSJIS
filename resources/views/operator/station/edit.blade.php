@extends('layouts.operator')

@section('title', 'Edit Charging Station')

@section('content')
<div class="container-fluid py-3">
    <h4 class="mb-3">Edit Charging Station</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('operator.station._form', [
                'action'      => route('operator.station.update', $station),
                'station'     => $station,
                'submitLabel' => 'Simpan perubahan',
            ])
        </div>
    </div>
</div>
@endsection