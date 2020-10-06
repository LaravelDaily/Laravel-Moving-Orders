<?php

namespace App\Http\Requests;

use App\Models\Moving;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMovingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('moving_create');
    }

    public function rules()
    {
        return [
            'moving_from' => [
                'string',
                'required',
            ],
            'moving_to'   => [
                'string',
                'required',
            ],
            'moving_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'comments'    => [
                'nullable',
                'string',
            ],
        ];
    }
}
