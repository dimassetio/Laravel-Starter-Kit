@extends('layouts.app')

@section('title', trans('sale.edit'))

@section('content')
    <div class="row"><br>
        <div class="col-md-8">
            {!! Form::model($sale, ['route' => ['sales.update', $sale->id], 'method' => 'PUT', 'id' => 'saleForm']) !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('sale.edit') }}</h3>
                </div>
                <div class="panel-body">
                    <!-- Dropdown for selecting product -->
                    {!! FormField::select('product_id', $products->pluck('name', 'id'), null, [
                        'label' => trans('sale.product'),
                        'id' => 'product_id',
                    ]) !!}

                    <!-- Price field (auto-filled) -->
                    {!! FormField::text('price', ['label' => trans('sale.price'), 'id' => 'price', 'readonly' => 'readonly']) !!}

                    <!-- Quantity field -->
                    {!! FormField::text('quantity', ['label' => trans('sale.quantity'), 'id' => 'quantity', 'min' => 1]) !!}

                    <!-- Total price field (readonly) -->
                    {!! FormField::text('total_price', [
                        'label' => trans('sale.total_price'),
                        'id' => 'total_price',
                        'readonly' => 'readonly',
                    ]) !!}

                    <!-- Sale date field -->
                    {!! FormField::text('sale_date', [
                        'label' => trans('sale.sale_date'),
                        'id' => 'sale_date',
                        'class' => 'form-control',
                        'placeholder' => 'YYYY-MM-DD',
                    ]) !!}
                </div>

                <div class="panel-footer">
                    {!! Form::submit(trans('sale.update'), ['class' => 'btn btn-primary']) !!}
                    {!! link_to_route('sales.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Datepicker initialization
            $('#sale_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            // When the product is changed
            $('#product_id').change(function() {
                var selectedProductId = $(this).val(); // Get the selected product ID

                console.log('Selected Product ID:', selectedProductId);

                // Make an AJAX call to get the price of the selected product
                $.ajax({
                    url: '/products/get-price/' + selectedProductId,
                    method: 'GET',
                    success: function(data) {
                        var selectedPrice = data; // Get the price from the response
                        console.log('Selected Price:', selectedPrice);

                        // Set the price field
                        $('#price').val(selectedPrice);

                        // Calculate total price if quantity is already entered
                        calculateTotal();
                    },
                    error: function() {
                        console.log('Error fetching product price.');
                        $('#price').val(''); // Clear price if there was an error
                    }
                });
            });

            // When the quantity is changed
            $('#quantity').on('input', function() {
                calculateTotal();
            });

            // Function to calculate total price
            function calculateTotal() {
                var price = parseFloat($('#price').val()) || 0;
                var quantity = parseInt($('#quantity').val()) || 0;
                var totalPrice = price * quantity;
                $('#total_price').val(totalPrice.toFixed(2)); // Set total price, formatted to 2 decimal places
            }
        });

        // Set initial values for price and quantity on page load
        $(document).ready(function() {
            $('#product_id').val({{ $sale->product_id }}).trigger('change'); // Trigger change to set price
            $('#quantity').val({{ $sale->quantity }}); // Set quantity
            $('#price').val({{ $sale->price }}); // Set price
            $('#total_price').val(({{ $sale->price }} * {{ $sale->quantity }}).toFixed(
            2)); // Calculate total price
        });
    </script>
@endsection
