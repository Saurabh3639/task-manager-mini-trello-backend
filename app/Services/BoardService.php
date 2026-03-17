<?php

namespace App\Services;

use App\Models\Board;

class BoardService
{
    public function createBoard($data, $userId)
    {
        return Board::create([
            'title' => $data['title'],
            'user_id' => $userId
        ]);
    }

    public function updateBoard(Board $board, $data)
    {
        $board->update($data);
        return $board;
    }

    public function deleteBoard(Board $board)
    {
        $board->delete();
        return true;
    }
}
