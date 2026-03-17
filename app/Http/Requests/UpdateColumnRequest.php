<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateColumnRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'board_id' => 'sometimes|exists:boards,id',
            'title' => 'sometimes|required|string|max:255',
            'position' => 'sometimes|integer',
        ];
    }
}
