@extends('layouts.app')

@section('title', trans('sale.sales'))

@section('content')
    <h1 class="page-header">
        {!! link_to_route('sales.create', trans('sale.create'), [], ['class' => 'btn btn-success pull-right']) !!}
        {{ trans('sale.sales') }} <small>{{ $sales->total() }} {{ trans('sale.found') }}</small>
    </h1>
    {{-- <div class="well well-sm">
        {!! Form::open(['method' => 'get', 'class' => 'form-inline']) !!}
        {!! Form::text('q', Request::get('q'), [
            'class' => 'form-control index-search-field',
            'placeholder' => trans('sale.search'),
            'style' => 'width:350px',
        ]) !!}
        {!! Form::submit(trans('sale.search'), ['class' => 'btn btn-info btn-sm']) !!}
        {!! link_to_route('sales.index', 'Reset', [], ['class' => 'btn btn-default btn-sm']) !!}
        {!! Form::close() !!}
    </div> --}}
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('sale.product') }}</th> <!-- Assuming you want to display the product name -->
            <th>{{ trans('sale.quantity') }}</th>
            <th>{{ trans('sale.price') }}</th>
            <th>{{ trans('sale.total') }}</th>
            <th>{{ trans('sale.date') }}</th>
            <th>{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($sales as $key => $sale)
                <tr>
                    <td>{{ $sales->firstItem() + $key }}</td>
                    <td>{{ $sale->product->name }}</td> <!-- Accessing product name from sale -->
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->price }}</td>
                    <td>{{ $sale->total }}</td>
                    <td>{{ $sale->sale_date }}</td>
                    <td>
                        {!! link_to_route('sales.show', trans('app.show'), [$sale->id], ['class' => 'btn btn-info btn-xs']) !!}
                        {!! link_to_route('sales.edit', trans('app.edit'), [$sale->id], ['class' => 'btn btn-warning btn-xs']) !!}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">{{ trans('sale.not_found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {!! str_replace('/?', '?', $sales->appends(Request::except('page'))->render()) !!}
@endsection
