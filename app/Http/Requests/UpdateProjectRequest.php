<?php

namespace App\Http\Requests;

use App\Models\Project;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProjectRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('project_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:8',
                'max:255',
                'required',
            ],
            'owner' => [
                'string',
                'max:255',
                'required',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'whatsapp' => [
                'integer',
                'nullable',
            ],
            'start_date' => [
                'date_format:' . config('project.date_format'),
                'required',
            ],
            'due_date' => [
                'date_format:' . config('project.date_format'),
                'required',
            ],
            'photo' => [
                'array',
                'nullable',
            ],
            'photo.*.id' => [
                'integer',
                'exists:media,id',
            ],
            'galery' => [
                'array',
                'nullable',
            ],
            'galery.*.id' => [
                'integer',
                'exists:media,id',
            ],
        ];
    }
}
