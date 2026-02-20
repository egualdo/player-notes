<?php

namespace App\Repositories;

use App\Models\PlayerNote;
use App\Repositories\Interfaces\PlayerNoteRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PlayerNoteRepository implements PlayerNoteRepositoryInterface
{
    public function __construct(
        private readonly PlayerNote $model
    ) {}

    public function getForPlayer(int $playerId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['author:id,name,email'])
            ->where('player_id', $playerId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function create(array $data): PlayerNote
    {
        $validator = Validator::make($data, [
            'content' => 'required|string|min:1|max:1000',
            'player_id' => 'required|exists:users,id',
            'author_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return DB::transaction(function () use ($data) {
            return $this->model->create([
                'player_id' => $data['player_id'],
                'author_id' => $data['author_id'],
                'content' => $data['content'],
            ]);
        });
    }

    public function delete(int $noteId): bool
    {
        return DB::transaction(function () use ($noteId) {
            return $this->model->where('id', $noteId)->delete();
        });
    }

    public function find(int $id): ?PlayerNote
    {
        return $this->model->with(['author', 'player'])->find($id);
    }
}
