@extends('layouts.app')

@section('content')
<h1 class="page-header">{{ $user->name }} <small>Detail</small></h1>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('user.user') }} Detail</h3></div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr><th>{{ trans('app.name') }}</th><td>{{ $user->name }}</td></tr>
                        <tr><th>{{ trans('auth.username') }}</th><td>{{ $user->username }}</td></tr>
                        <tr><th>{{ trans('user.email') }}</th><td>{{ $user->email }}</td></tr>
                        <tr>
                            <th>{{ trans('user.role') }}</th>
                            <td>{{ $user->present()->displayRoles }}</td>
                        </tr>
                        <tr><th>{{ trans('user.registered_at') }}</th><td>{{ $user->created_at }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="panel-footer">
    {!! link_to_route('users.edit', trans('app.edit'), [$user->id], ['class' => 'btn btn-warning']) !!}
    {!! link_to_route('users.index', trans('user.back_to_index'), [], ['class' => 'btn btn-default']) !!}
</div>
@endsection