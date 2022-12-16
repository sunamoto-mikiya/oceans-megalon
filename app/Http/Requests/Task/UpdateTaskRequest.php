<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id'     => 'nullable|integer',
            'title'       => 'required|max:255',
            'type'        => 'required|integer',
            'status'      => 'required|integer',
            'description' => 'nullable',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date',
            'file'        => 'nullable|mimes:png,jpg,jpeg|max:10240',
        ];
    }
}
