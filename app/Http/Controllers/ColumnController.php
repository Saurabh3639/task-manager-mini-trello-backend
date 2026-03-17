<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\Request;
use App\Http\Requests\StoreColumnRequest;
use App\Http\Requests\UpdateColumnRequest;
use App\Http\Resources\ColumnResource;
use App\Services\ColumnService;

class ColumnController extends Controller
{
    protected $columnService;

    public function __construct(ColumnService $columnService)
    {
        $this->columnService = $columnService;
    }

    public function index(Request $request)
    {
        $columns = Column::where('board_id', $request->board_id)
                    ->orderBy('position')
                    ->get();

        return ColumnResource::collection($columns);
    }

    public function store(StoreColumnRequest $request)
    {
        $this->authorize('create', [Column::class, $request->board_id]);

        $column = $this->columnService->createColumn($request->validated());

        return new ColumnResource($column);
    }

    public function update(UpdateColumnRequest $request, $id)
    {
        $column = Column::findOrFail($id);

        $this->authorize('update', $column);

        $column = $this->columnService->updateColumn($column, $request->validated());

        return new ColumnResource($column);
    }

    public function destroy($id)
    {
        $column = Column::findOrFail($id);

        $this->authorize('delete', $column);

        $this->columnService->deleteColumn($column);

        return response()->json([
            "message" => "Column deleted"
        ]);
    }

}
