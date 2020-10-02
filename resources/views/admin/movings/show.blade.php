@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.moving.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.movings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.id') }}
                        </th>
                        <td>
                            {{ $moving->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.user') }}
                        </th>
                        <td>
                            {{ $moving->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.moving_from') }}
                        </th>
                        <td>
                            {{ $moving->moving_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.moving_to') }}
                        </th>
                        <td>
                            {{ $moving->moving_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.moving_date') }}
                        </th>
                        <td>
                            {{ $moving->moving_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.comments') }}
                        </th>
                        <td>
                            {{ $moving->comments }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.price') }}
                        </th>
                        <td>
                            {{ $moving->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.paid_at') }}
                        </th>
                        <td>
                            {{ $moving->paid_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.movings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection