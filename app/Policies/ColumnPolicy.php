<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\Column;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ColumnPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Column $column)
    {
        return $user->id === $column->board->user_id;
    }

    public function create(User $user, $board_id) // We'll pass board_id or Board instance in controller
    {
        $board = \App\Models\Board::find($board_id);
        return $board && $user->id === $board->user_id;
    }

    public function update(User $user, Column $column)
    {
        return $user->id === $column->board->user_id;
    }

    public function delete(User $user, Column $column)
    {
        return $user->id === $column->board->user_id;
    }
}
