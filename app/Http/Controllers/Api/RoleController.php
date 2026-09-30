<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Validation\Rule;

class RoleController extends CrudController
{
    protected function model(): string
    {
        return Role::class;
    }

    protected function relations(): array
    {
        return ['hakAkses'];
    }

    protected function rules(?int $id = null): array
    {
        return [
            'nm_role' => ['required', 'string', 'max:50',
                 Rule::unique('role', 'nm_role')
                    ->ignore($id, 'id_role')],
            'status' => 'required|in:aktif,nonaktif',
        ];
    }
}