@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <br>

    <div class="container">
        <div class="d-flex row justify-content-between align-items-center">
            <h1>{{ trans('sale.monthly_sales') }}</h1>

            {{-- Year Dropdown --}}
            <select id="yearSelect" class="form-control" style="width: 150px;">
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>


        {{-- Chart --}}
        <div class="p-4" style="margin-top: 24px; margin-bottom: 24px">
            <canvas id="salesChart" width="400" height="200" class="my-4"></canvas>
        </div>

        <h1 class="my-3">{{ trans('sale.sales_table') }}</h1>
        {{-- Sales Table --}}
        <table class="table table-bordered" id="salesTable">
            <thead>
                <tr>
                    <th>{{ trans('sale.month') }}</th>
                    <th>{{ trans('sale.product') }}</th>
                    <th>{{ trans('sale.total_quantity') }}</th>
                    <th>{{ trans('sale.total_sales') }}</th>
                </tr>
            </thead>
            <tbody>
                {{-- Table content will be updated dynamically --}}
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const yearSelect = document.getElementById('yearSelect');
            let salesChart;
            const decimalFormatter = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0, // Number of digits after the decimal point
                maximumFractionDigits: 0, // Maximum number of digits after the decimal point
            });

            // Function to fetch and update sales data based on the selected year
            function updateSalesData(year) {
                fetch(`/monthly-sales?year=${year}`)
                    .then(response => response.json())
                    .then(salesData => {
                        console.log('salesData:', salesData);

                        // Prepare data for the chart
                        const products = [...new Set(salesData.map(sale => sale.product.name))];
                        const labels = [...new Set(salesData.map(sale =>
                            `${sale.year}-${('0' + sale.month).slice(-2)}`))];

                        const datasets = products.map((product, index) => {
                            const productSales = salesData.filter(sale => sale.product.name ===
                                product);
                            const data = labels.map(label => {
                                const [year, month] = label.split('-');
                                const sale = productSales.find(s => s.year == year && s.month ==
                                    month);
                                return sale ? sale.total_sales : 0;
                            });

                            return {
                                label: product,
                                data: data,
                                borderColor: `rgba(${index * 50}, ${index * 100}, ${index * 150}, 0.7)`,
                                fill: false,
                                tension: 0.1
                            };
                        });

                        // Update the chart
                        if (salesChart) {
                            salesChart.destroy();
                        }

                        salesChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        type: 'category',
                                        title: {
                                            display: true,
                                            text: 'Month'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Total Sales'
                                        }
                                    }
                                }
                            }
                        });

                        // Update the sales table
                        const salesTableBody = document.querySelector('#salesTable tbody');
                        salesTableBody.innerHTML = '';

                        salesData.forEach(sale => {


                            const row = `
                                <tr>
                                    <td>${new Date(sale.year, sale.month - 1).toLocaleString('default', { month: 'long', year: 'numeric' })}</td>
                                    <td>${sale.product.name}</td>
                                    <td>${sale.total_quantity}</td>
                                    <td>Rp${decimalFormatter.format(sale.total_sales)}</td>
                                </tr>
                            `;
                            salesTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    })
                    .catch(error => console.error('Error fetching sales data:', error));
            }

            // Function to format numbers with commas
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Event listener for year selection change
            yearSelect.addEventListener('change', function() {
                const selectedYear = this.value;
                updateSalesData(selectedYear);
            });

            // Initialize with the selected year
            updateSalesData(yearSelect.value);
        });
    </script>
@endsection
