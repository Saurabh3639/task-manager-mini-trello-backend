<?php

namespace App\Services;

use App\Models\Column;

class ColumnService
{
    public function createColumn($data)
    {
        return Column::create($data);
    }

    public function updateColumn(Column $column, $data)
    {
        $column->update($data);
        return $column;
    }

    public function deleteColumn(Column $column)
    {
        $column->delete();
        return true;
    }
}
