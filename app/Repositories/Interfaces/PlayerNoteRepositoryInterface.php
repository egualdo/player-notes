<?php

namespace App\Repositories\Interfaces;

use App\Models\PlayerNote;
use Illuminate\Pagination\LengthAwarePaginator;

interface PlayerNoteRepositoryInterface
{
    public function getForPlayer(int $playerId, int $perPage = 15): LengthAwarePaginator;
    public function create(array $data): PlayerNote;
    public function delete(int $noteId): bool;
    public function find(int $id): ?PlayerNote;
}
