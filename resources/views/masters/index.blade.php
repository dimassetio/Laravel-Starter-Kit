@extends('layouts.app')

@section('content')
<h1 class="page-header">
    {!! link_to_route('masters.create', trans('master.create'), [], ['class'=>'btn btn-success pull-right']) !!}
    {{ trans('master.masters') }} <small>{{ $masters->total() }} {{ trans('master.found') }}</small>
</h1>
{!! Form::open(['method'=>'get','class'=>'pull-right index-search-form']) !!}
{!! Form::text('q', Input::get('q'), ['class'=>'form-control','placeholder'=>trans('master.search')]) !!}
{!! Form::close() !!}
<table class="table table-condensed">
    <thead>
        <th>{{ trans('app.table_no') }}</th>
        <th>{{ trans('app.name') }}</th>
        <th>{{ trans('app.description') }}</th>
        <th>{{ trans('app.created_at') }}</th>
        <th>{{ trans('app.action') }}</th>
    </thead>
    <tbody>
        @forelse($masters as $key => $master)
        <tr>
            <td>{{ $masters->firstItem() + $key }}</td>
            <td>{{ $master->name }}</td>
            <td>{{ $master->description }}</td>
            <td>{{ $master->created_at }}</td>
            <td>
                {!! link_to_route('masters.show',trans('app.show'),[$master->id],['class'=>'btn btn-info btn-xs']) !!}
                {!! link_to_route('masters.edit',trans('app.edit'),[$master->id],['class'=>'btn btn-warning btn-xs']) !!}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">{{ trans('master.not_found') }}</td>
        </tr>
        @endforelse
    </tbody>
</table>
    {!! str_replace('/?', '?', $masters->appends(Input::except('page'))->render()) !!}
@endsection
