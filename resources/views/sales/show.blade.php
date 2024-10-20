@extends('layouts.app')

@section('title', trans('sale.show'))

@section('content')
    <h1 class="page-header">{{ trans('sale.show_details') }} <small>{{ trans('sale.for') }}
            {{ $sale->product->name }}</small></h1>
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('sale.show') }}</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <th>{{ trans('sale.product') }}</th>
                                <td>{{ $sale->product->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('sale.quantity') }}</th>
                                <td>{{ $sale->quantity }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('sale.price') }}</th>
                                <td>{{ trans('app.currency') }}{{ number_format($sale->price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('sale.total_price') }}</th>
                                <td>{{ trans('app.currency') }}{{ number_format($sale->total, 2) }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('sale.sale_date') }}</th>
                                <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    {!! link_to_route('sales.edit', trans('app.edit'), [$sale->id], ['class' => 'btn btn-warning']) !!}
                    {!! link_to_route('sales.index', trans('product.back_to_index'), [], ['class' => 'btn btn-default']) !!}
                    <div class="pull-right">
                        {!! Form::open([
                            'route' => ['sales.destroy', $sale->id],
                            'method' => 'delete',
                            'style' => 'display:hidden;',
                            'id' => 'delete-form',
                        ]) !!}
                        {!! Form::button(trans('app.delete'), [
                            'class' => 'btn btn-danger',
                            'type' => 'button',
                            'onclick' => "confirmDelete($sale->id)",
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
                if (confirm('Apakah anda yakin ingin menghapus penjualan ini? Perintah ini tidak dapat dibatalkan.')) {
                    // Submit the form
                    form.submit();
                }
            } else {
                console.error('Form not found: delete-form');
            }
        }
    </script>
@endsection
