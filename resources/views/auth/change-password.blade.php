@extends('layouts.app')

@section('content')
<br>
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Change Password</h3></div>
        <div class="panel-body">
            @include('auth.partials._notifications')
            {!! Form::open(['route'=>'auth.change-password','class'=>'form-horizontal']) !!}
            <div class="form-group {!! $errors->has('old_password') ? 'has-error' : ''; !!}">
                {!! Form::label('old_password', trans('auth.old_password'), ['class'=>'col-md-4 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::password('old_password', ['class'=>'form-control','placeholder'=> trans('auth.old_password')]) !!}
                </div>
            </div>
            <div class="form-group {!! $errors->has('password') ? 'has-error' : ''; !!}">
                {!! Form::label('password', trans('auth.new_password'), ['class'=>'col-md-4 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::password('password', ['class'=>'form-control','placeholder'=>trans('auth.new_password')]) !!}
                </div>
            </div>
            <div class="form-group {!! $errors->has('password_confirmation') ? 'has-error' : ''; !!}">
                {!! Form::label('password_confirmation', trans('auth.new_password_confirmation'), ['class'=>'col-md-4 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::password('password_confirmation', ['class'=>'form-control','placeholder'=>trans('auth.new_password_confirmation')]) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    {!! Form::submit(trans('auth.change_password'), ['class'=>'btn btn-info']) !!}
                    {!! link_to_route('home',trans('app.cancel'),[],['class'=>'btn btn-default']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
