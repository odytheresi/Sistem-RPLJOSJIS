 @extends('layouts.operator')

@section('title', 'Edit Maintenance')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @include('operator.perbaikan._form', [
            'action'      => route('operator.perbaikan.update', $perbaikan),
            'perbaikan'   => $perbaikan,
            'chargers'    => $chargers,
            'keluhan'     => $keluhan,
            'submitLabel' => 'Simpan Perubahan',
        ])
    </div>
</div>
@endsection