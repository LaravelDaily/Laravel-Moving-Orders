@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.moving.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.movings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="moving_from">{{ trans('cruds.moving.fields.moving_from') }}</label>
                <input class="form-control {{ $errors->has('moving_from') ? 'is-invalid' : '' }}" type="text" name="moving_from" id="moving_from" value="{{ old('moving_from', '') }}" required>
                @if($errors->has('moving_from'))
                    <div class="invalid-feedback">
                        {{ $errors->first('moving_from') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moving.fields.moving_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="moving_to">{{ trans('cruds.moving.fields.moving_to') }}</label>
                <input class="form-control {{ $errors->has('moving_to') ? 'is-invalid' : '' }}" type="text" name="moving_to" id="moving_to" value="{{ old('moving_to', '') }}" required>
                @if($errors->has('moving_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('moving_to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moving.fields.moving_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="moving_date">{{ trans('cruds.moving.fields.moving_date') }}</label>
                <input class="form-control date {{ $errors->has('moving_date') ? 'is-invalid' : '' }}" type="text" name="moving_date" id="moving_date" value="{{ old('moving_date') }}" required>
                @if($errors->has('moving_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('moving_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moving.fields.moving_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comments">{{ trans('cruds.moving.fields.comments') }}</label>
                <textarea class="form-control {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{{ old('comments') }}</textarea>
                @if($errors->has('comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moving.fields.comments_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection