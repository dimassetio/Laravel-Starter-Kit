@extends('layouts.app')

@section('content')
<br>
<div class="alert alert-info">
    {{ trans('app.welcome') }}
    <strong>{{ auth()->user()->name }}</strong> | {{ auth()->user()->present()->usernameRoles }}
    your Permissions:
    {{ auth()->user()->present()->displayPermissions }}
</div>
@endsection