<?php

namespace App\Http\Controllers\Api;

use App\Models\KonfigSistem;
use Illuminate\Validation\Rule;

class KonfigSistemController extends CrudController
{
    protected function model(): string
    {
        return KonfigSistem::class;
    }

    protected function rules(?int $id = null): array
    {
        return [
            'nm_konfig' => ['required', 'string', 'max:100',
                Rule::unique('konfig_sistem', 'nm_konfig')->ignore($id, 'id_konfig')],
            'nilai'     => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ];
    }
}