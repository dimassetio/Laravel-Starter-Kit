@extends('layouts.app')

@section('title', trans('product.products'))

@section('content')
    <h1 class="page-header">
        {!! link_to_route('products.create', trans('product.create'), [], ['class' => 'btn btn-success pull-right']) !!}
        {{ trans('product.products') }} <small>{{ $products->total() }} {{ trans('product.found') }}</small>
    </h1>
    {{-- <div class="well well-sm">
        {!! Form::open(['method' => 'get', 'class' => 'form-inline']) !!}
        {!! Form::text('q', Request::get('q'), [
            'class' => 'form-control index-search-field',
            'placeholder' => trans('product.search'),
            'style' => 'width:350px',
        ]) !!}
        {!! Form::submit(trans('product.search'), ['class' => 'btn btn-info btn-sm']) !!}
        {!! link_to_route('products.index', 'Reset', [], ['class' => 'btn btn-default btn-sm']) !!}
        {!! Form::close() !!}
    </div> --}}
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('app.name') }}</th>
            <th>{{ trans('app.description') }}</th>
            <th>{{ trans('product.price') }}</th>
            <th>{{ trans('app.created_at') }}</th>
            <th>{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($products as $key => $product)
                <tr>
                    <td>{{ $products->firstItem() + $key }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>
                        {!! link_to_route('products.show', trans('app.show'), [$product->id], ['class' => 'btn btn-info btn-xs']) !!}
                        {!! link_to_route('products.edit', trans('app.edit'), [$product->id], ['class' => 'btn btn-warning btn-xs']) !!}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">{{ trans('product.not_found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {!! str_replace('/?', '?', $products->appends(Request::except('page'))->render()) !!}
@endsection
