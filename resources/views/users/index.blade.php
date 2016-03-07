@extends('layouts.app')

@section('content')
<h1 class="page-header">
    {!! link_to_route('users.create', trans('user.create'), [], ['class'=>'btn btn-success pull-right']) !!}
    {{ trans('user.users') }} <small>{{ $users->total() }} {{ trans('user.found') }}</small>
</h1>
{!! Form::open(['method'=>'get','class'=>'pull-right index-search-form']) !!}
@if (Request::has('role'))
{!! Form::hidden('role', Request::get('role')) !!}
@endif
{!! Form::text('q', Request::get('q'), ['class'=>'form-control','placeholder'=>trans('user.search')]) !!}
{!! Form::close() !!}

<table class="table table-condensed">
    <thead>
        <th>{{ trans('app.table_no') }}</th>
        <th>{{ trans('app.name') }}</th>
        <th>{{ trans('auth.username') }}</th>
        <th>{{ trans('user.email') }}</th>
        <th>{{ trans('user.roles') }}</th>
        <th>{{ trans('app.action') }}</th>
    </thead>
    <tbody>
        @forelse($users as $key => $user)
        <tr>
            <td>{{ $users->firstItem() + $key }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{!! $user->present()->roleslink !!}</td>
            <td>
                {!! link_to_route('users.show','Show',[$user->id],['class'=>'btn btn-info btn-xs']) !!}
                {!! link_to_route('users.edit','Edit',[$user->id],['class'=>'btn btn-warning btn-xs']) !!}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">{{ trans('user.not_found') }}</td>
        </tr>
        @endforelse
    </tbody>
</table>
    {!! str_replace('/?', '?', $users->appends(Request::except('page'))->render()) !!}
@endsection
