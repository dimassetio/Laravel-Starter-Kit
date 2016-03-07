@extends('layouts.guest')

@section('content')
<div class="col-md-6 col-md-offset-3">
    <div class="login-panel panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Reset Password</h3></div>
        <div class="panel-body">
            @include('auth.partials._notifications')
            {!! Form::open(['route'=>'auth.post-reset','class'=>'form-horizontal']) !!}
            <div class="form-group {!! $errors->has('email') ? 'has-error' : ''; !!}">
                {!! Form::label('email', trans('user.email'), ['class'=>'col-md-5 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::email('email', null, ['class'=>'form-control','placeholder'=>trans('user.email')]) !!}
                </div>
            </div>
            <div class="form-group {!! $errors->has('password') ? 'has-error' : ''; !!}">
                {!! Form::label('password', trans('user.new_password'), ['class'=>'col-md-5 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::password('password', ['class'=>'form-control','placeholder'=>trans('user.new_password')]) !!}
                </div>
            </div>
            <div class="form-group {!! $errors->has('password_confirmation') ? 'has-error' : ''; !!}">
                {!! Form::label('password_confirmation', trans('user.new_password_confirmation'), ['class'=>'col-md-5 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::password('password_confirmation', ['class'=>'form-control','placeholder'=>trans('user.new_password_confirmation')]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-5">
                    {!! Form::submit('Reset Password', ['class'=>'btn btn-info']) !!}
                </div>
            </div>
            {!! Form::hidden('token', $token) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
