```blade
@extends('layouts.operator')

@section('title', 'Tambah Maintenance')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @include('operator.perbaikan._form', [
            'action' => route('operator.perbaikan.store'),
            'perbaikans' => null,
            'perbaikan' => null,
            'chargers' => $chargers,
            'keluhan' => $keluhan,
            'submitLabel' => 'Simpan Maintenance',
        ])
    </div>
</div>
@endsection
```