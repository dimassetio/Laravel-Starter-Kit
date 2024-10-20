@extends('layouts.app')

@section('title', trans('product.create'))

@section('content')
    <div class="row"><br>
        <div class="col-md-8">
            {!! Form::open(['route' => 'products.store']) !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('product.create') }}</h3>
                </div>
                <div class="panel-body">
                    {!! FormField::text('name', ['label' => trans('app.name')]) !!}
                    {!! FormField::textarea('description', ['label' => trans('app.description')]) !!}
                    {!! FormField::text('price', ['label' => trans('product.price')]) !!}
                </div>

                <div class="panel-footer">
                    {!! Form::submit(trans('product.create'), ['class' => 'btn btn-primary']) !!}
                    {!! link_to_route('products.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
