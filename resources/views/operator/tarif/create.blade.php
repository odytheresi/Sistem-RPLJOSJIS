@extends('layouts.operator')

@section('title', 'Atur Tarif Baru')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @include('operator.tarif._form', [
            'action'         => route('operator.tarif.store'),
            'chargers'       => $chargers,
            'submitLabel'    => 'Simpan tarif',
            'confirmMessage' => 'Tetapkan tarif ini? Tarif lama pada charger yang sama akan digantikan.',
        ])
    </div>
</div>
@endsection