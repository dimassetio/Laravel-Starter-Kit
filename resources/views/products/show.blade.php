@extends('layouts.app')

@section('title', trans('product.show'))

@section('content')
    <h1 class="page-header">{{ $product->name }} <small>{{ trans('product.show') }}</small></h1>
    <div class="row">
        <div class=" col-12 col-md-8 col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('product.show') }}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <th>{{ trans('app.name') }}</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('app.description') }}</th>
                                <td>{{ $product->description }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('product.price') }}</th>
                                <td>{{ trans('app.currency') }}{{ number_format($product->price, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    {!! link_to_route('products.edit', trans('app.edit'), [$product->id], ['class' => 'btn btn-warning']) !!}
                    {!! link_to_route('products.index', trans('product.back_to_index'), [], ['class' => 'btn btn-default']) !!}
                    <div class="pull-right">
                        {!! Form::open([
                            'route' => ['products.destroy', $product->id],
                            'method' => 'delete',
                            'style' => 'display:hidden;',
                            'id' => 'delete-form',
                        ]) !!}
                        {!! Form::button(trans('app.delete'), [
                            'class' => 'btn btn-danger',
                            'type' => 'button',
                            'onclick' => "confirmDelete($product->id)",
                        ]) !!}
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
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
