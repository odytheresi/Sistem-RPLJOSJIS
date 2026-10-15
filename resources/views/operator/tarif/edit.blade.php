@extends('layouts.operator')

@section('title', 'Edit Tarif')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @include('operator.tarif._form', [
            'action'         => route('operator.tarif.update', $tarif),
            'tarif'          => $tarif,
            'chargers'       => $chargers,
            'submitLabel'    => 'Simpan perubahan',
            'confirmMessage' => 'Simpan perubahan tarif ini?',
        ])
    </div>
</div>
@endsection