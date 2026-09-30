<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class CrudController extends Controller
{
    /** @return class-string<Model> */
    abstract protected function model(): string;

    abstract protected function rules(?int $id = null): array;

    protected function relations(): array
    {
        return [];
    }

    protected function prepare(array $data): array
    {
        return $data;
    }

    public function index(): JsonResponse
    {
        $m = $this->model();
        $key = (new $m)->getKeyName();

        return response()->json(
            $m::with($this->relations())
                ->orderByDesc($key)->paginate(15)
        );
    }

    public function show(int $id): JsonResponse
    {
        $m = $this->model();

        return response()->json($m::with($this->relations())
            ->findOrFail($id));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->prepare($request->validate($this->rules()));
        $m = $this->model();
        $record = $m::create($data);

        $this->catat('tambah', $record);

        return response()->json($record->load($this->relations()), 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $m = $this->model();
        $record = $m::findOrFail($id);
        $record->update($this->prepare($request->validate($this->rules($id))));

        $this->catat('ubah', $record);

        return response()->json($record->load($this->relations()));
    }

    public function destroy(int $id): JsonResponse
    {
        $m = $this->model();
        $record = $m::findOrFail($id);
        $record->delete();

        $this->catat('hapus', $record);

        return response()->json(['message' => 'Data dihapus.']);
    }

    protected function catat(string $aktivitas, Model $record): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => $aktivitas,
            'entitas_terkait' => class_basename($record),
            'id_referensi' => (string) $record->getKey(),
            'keterangan' => "$aktivitas " . class_basename($record) . ' #' . $record->getKey(),
        ]);
    }
}