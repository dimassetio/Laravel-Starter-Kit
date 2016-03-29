@extends('layouts.app')

@section('content')
<br>
<div class="alert alert-info">
    {{ trans('app.welcome') }}
    <strong>{{ auth()->user()->name }}</strong> | {{ auth()->user()->present()->usernameRoles }}
    <p>Your Permissions:
        {!! auth()->user()->present()->displayPermissions !!}</p>
</div>
@endsection