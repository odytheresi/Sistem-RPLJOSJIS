@extends('layouts.operator')

@section('title', 'Edit Charger')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @include('operator.charger._form', [
            'action'      => route('operator.charger.update', $charger),
            'charger'     => $charger,
            'stations'    => $stations,
            'konektors'   => $konektors,
            'submitLabel' => 'Simpan perubahan',
        ])
    </div>
</div>
@endsection