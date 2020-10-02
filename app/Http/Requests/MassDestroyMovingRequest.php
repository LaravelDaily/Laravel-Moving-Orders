<?php

namespace App\Http\Requests;

use App\Models\Moving;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMovingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('moving_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:movings,id',
        ];
    }
}
