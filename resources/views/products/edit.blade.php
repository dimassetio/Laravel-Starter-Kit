@extends('layouts.app')

@section('title', trans('product.edit'))

@section('content')
    <div class="row"><br>
        <div class="col">
            {!! Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'patch']) !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $product->name }} <small>{{ trans('product.edit') }}</small></h3>
                </div>
                <div class="panel-body">
                    {!! FormField::text('name', ['label' => trans('app.name')]) !!}
                    {!! FormField::textarea('description', ['label' => trans('app.description')]) !!}
                    {!! FormField::text('price', ['label' => trans('product.price')]) !!}
                </div>

                <div class="panel-footer">
                    {!! Form::submit(trans('product.update'), ['class' => 'btn btn-primary']) !!}
                    {!! link_to_route('products.show', trans('app.show'), [$product->id], ['class' => 'btn btn-info']) !!}
                    {!! link_to_route('products.index', trans('product.back_to_index'), [], ['class' => 'btn btn-default']) !!}
                    {{-- <div class="pull-right">
                        {!! Form::open([
                            'route' => ['products.destroy', $product->id],
                            'method' => 'delete',
                            'style' => 'display:hidden;',
                            'id' => 'delete-form-' . $product->id,
                        ]) !!}
                        {!! Form::button(trans('app.delete'), [
                            'class' => 'btn btn-danger hidden',
                            'type' => 'button',
                            'onclick' => "confirmDelete($product->id)",
                        ]) !!}
                        {!! Form::close() !!}
                    </div> --}}
                    {{-- <div class="pull-right">
                        {!! Form::open([
                            'route' => ['products.destroy', $product->id],
                            'method' => 'delete',
                            'style' => 'display:inline;',
                            'onsubmit' => 'return confirm("Apakah anda yakin ingin menghapus produk ini?");',
                        ]) !!}
                        {!! Form::button(trans('app.delete'), ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                        {!! Form::close() !!}
                    </div> --}}

                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <script>
        function confirmDelete(productId) {
            // Get the form element
            var form = document.getElementById('delete-form');

            // Check if the form exists
            if (form) {
                if (confirm('Apakah anda yakin ingin menghapus produk ini? Perintah ini tidak dapat dibatalkan.')) {
                    // Submit the form
                    form.submit();
                }
            } else {
                console.error('Form not found: delete-form');
            }
        }
    </script>
@endsection
