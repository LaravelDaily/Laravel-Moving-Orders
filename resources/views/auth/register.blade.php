@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card mx-4">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <h1>{{ trans('panel.site_title') }}</h1>
                    <p class="text-muted">{{ trans('global.register') }}</p>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-box fa-fw"></i>
                            </span>
                        </div>
                        <input type="text" name="moving_from" class="form-control{{ $errors->has('moving_from') ? ' is-invalid' : '' }}" required autofocus placeholder="{{ trans('cruds.moving.fields.moving_from') }}" value="{{ old('moving_from', null) }}">
                        @if($errors->has('moving_from'))
                            <div class="invalid-feedback">
                                {{ $errors->first('moving_from') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-box fa-fw"></i>
                            </span>
                        </div>
                        <input type="text" name="moving_to" class="form-control{{ $errors->has('moving_to') ? ' is-invalid' : '' }}" required placeholder="{{ trans('cruds.moving.fields.moving_to') }}" value="{{ old('moving_to', null) }}">
                        @if($errors->has('moving_to'))
                            <div class="invalid-feedback">
                                {{ $errors->first('moving_to') }}
                            </div>
                        @endif
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-box fa-fw"></i>
                            </span>
                        </div>
                        <input type="text" name="moving_date" class="form-control date{{ $errors->has('moving_date') ? ' is-invalid' : '' }}" required placeholder="{{ trans('cruds.moving.fields.moving_date') }}" value="{{ old('moving_date', null) }}">
                        @if($errors->has('moving_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('moving_date') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-box fa-fw"></i>
                            </span>
                        </div>
                        <textarea name="comments" class="form-control date{{ $errors->has('moving_date') ? ' is-invalid' : '' }}" placeholder="{{ trans('cruds.moving.fields.comments') }}">{{ old('comments', null) }}</textarea>
                        @if($errors->has('comments'))
                            <div class="invalid-feedback">
                                {{ $errors->first('moving_date') }}
                            </div>
                        @endif
                    </div>

                    <hr />

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user fa-fw"></i>
                            </span>
                        </div>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.user_name') }}" value="{{ old('name', null) }}">
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-envelope fa-fw"></i>
                            </span>
                        </div>
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock fa-fw"></i>
                            </span>
                        </div>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock fa-fw"></i>
                            </span>
                        </div>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="{{ trans('global.login_password_confirmation') }}">
                    </div>

                    <button class="btn btn-block btn-primary">
                        {{ trans('global.register') }}
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection