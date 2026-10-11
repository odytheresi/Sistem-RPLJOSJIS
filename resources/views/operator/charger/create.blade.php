@extends('layouts.operator')

@section('title', 'Tambah Charger')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @include('operator.charger.form', [
            'action'      => route('operator.charger.store'),
            'stations'    => $stations,
            'konektors'   => $konektors,
            'submitLabel' => 'Simpan charger',
        ])
    </div>
</div>
@endsection