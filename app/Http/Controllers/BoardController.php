<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Http\Resources\BoardResource;
use App\Services\BoardService;
use App\Helpers\ApiResponse;

class BoardController extends Controller
{
    protected $boardService;

    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
    }

    public function index()
    {
        $boards = Board::where('user_id', auth()->id())->withCount('tasks')->paginate(10);
        return BoardResource::collection($boards);
    }

    public function store(StoreBoardRequest $request)
    {
        $board = $this->boardService->createBoard(
            $request->validated(),
            auth()->id()
        );

        $board->loadCount('tasks');
        return new BoardResource($board);
    }

    public function update(UpdateBoardRequest $request, $id)
    {
        $board = Board::findOrFail($id);

        $this->authorize('update', $board);

        $board = $this->boardService->updateBoard($board, $request->validated());

        $board->loadCount('tasks');
        return new BoardResource($board);
    }

    public function destroy($id)
    {
        $board = Board::findOrFail($id);

        $this->authorize('delete', $board);

        $this->boardService->deleteBoard($board);

        return response()->json([
            'message' => 'Board deleted'
        ]);
    }

}
