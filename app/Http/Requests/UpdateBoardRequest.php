<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBoardRequest extends FormRequest
{
    public function authorize()
    {
        // Authorization is handled by Policies via Controller
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
        ];
    }
}
