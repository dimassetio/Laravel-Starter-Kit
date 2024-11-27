@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <br>

    <div class="container">
        <h1 class="page-header">
            {{ trans('sale.sales_dashboard') }}

            {{-- Year Dropdown --}}
            <select id="yearSelect" class="form-control pull-right" style="width: 150px; margin-left: 16px">
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>

            {{-- DB Dropdown --}}
            <select id="dbSelect" class="form-control pull-right" style="width: 150px; margin-left: 16px">
                @foreach ($units as $unit)
                    <option value="{{ $unit->nama_db }}">{{ $unit->unit_nama }}</option>
                @endforeach
            </select>
        </h1>

        <h3>{{ trans('sale.yearly_graph') }}</h3>


        {{-- Chart --}}
        <div class="p-4" style="margin-top: 24px; margin-bottom: 24px">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-4 border">
                        <canvas id="yearlyQtyChart"></canvas>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 border">
                        <canvas id="yearlyRpChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4" style="margin-top: 24px; margin-bottom: 24px">
            <h3 class="my-3">{{ trans('sale.monthly_graph') }}</h3>
            <canvas id="monthlyQtyChart" width="400" height="150" class="my-4" style="margin-bottom: 24px"></canvas>
            <canvas id="monthlyRpChart" width="400" height="150" class="my-4"></canvas>
        </div>


    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Yearly
            const ctxYearlyQty = document.getElementById('yearlyQtyChart').getContext('2d');
            let yearlyQtyChart;
            const ctxYearlyRp = document.getElementById('yearlyRpChart').getContext('2d');
            let yearlyRpChart;
            // Monthly
            const ctxMonthlyQty = document.getElementById('monthlyQtyChart').getContext('2d');
            let monthlyQtyChart;
            const ctxMonthlyRp = document.getElementById('monthlyRpChart').getContext('2d');
            let monthlyRpChart;

            const yearSelect = document.getElementById('yearSelect');
            const dbSelect = document.getElementById('dbSelect');

            const decimalFormatter = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0, // Number of digits after the decimal point
                maximumFractionDigits: 0, // Maximum number of digits after the decimal point
            });


            function updateProductYearly(db, year) {
                fetch(`/productYearlyReport?nama_db=${db}&year=${year}`)
                    .then(response => response.json())
                    .then(responseData => {
                        console.log('responseData:', responseData);

                        // Prepare data for the chart
                        const labels = responseData.map(item => item.group_nama);
                        const totalQty = responseData.map(item => item.total_qty);
                        const totalRp = responseData.map(item => item.total_rp);

                        const datasets = [{
                                label: `Total Kuantitas Produk Tahun ${year}`,
                                data: totalQty,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: `Total Revenue Produk Tahun ${year}`,
                                data: totalRp,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ];

                        // Update the chart
                        if (yearlyQtyChart) {
                            yearlyQtyChart.destroy();
                        }
                        if (yearlyRpChart) {
                            yearlyRpChart.destroy();
                        }

                        function chartOptions(title) {
                            return {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: title
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            };
                        }

                        yearlyQtyChart = new Chart(ctxYearlyQty, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [datasets[0]]
                            },
                            options: chartOptions(`Total Kuantitas Produk Tahun ${year}`)
                        });

                        yearlyRpChart = new Chart(ctxYearlyRp, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [datasets[1]]
                            },
                            options: chartOptions(`Total Revenue Produk Tahun ${year}`)
                        });
                    })
                    .catch(error => console.error('Error fetching sales data:', error));
            }

            function updateProductMonthly(db, year) {
                fetch(`/productMonthlyReport?nama_db=${db}&year=${year}`)
                    .then(response => response.json())
                    .then(data => {
                        // Prepare data for the chart
                        const labels = data.map(item => `Bulan ${item.bulan}`);
                        const qtyHijau = data.map(item => item.qty_hijau);
                        const qtyJp = data.map(item => item.qty_jp);
                        const qtyCtc = data.map(item => item.qty_ctc);
                        const qtyHitam = data.map(item => item.qty_hitam);
                        const qtyTotal = data.map(item => item.qty_total);

                        const rpHijau = data.map(item => item.rp_hijau);
                        const rpJp = data.map(item => item.rp_jp);
                        const rpCtc = data.map(item => item.rp_ctc);
                        const rpHitam = data.map(item => item.rp_hitam);
                        const rpTotal = data.map(item => item.rp_total);

                        // Update the chart
                        if (monthlyQtyChart) {
                            monthlyQtyChart.destroy();
                        }
                        if (monthlyRpChart) {
                            monthlyRpChart.destroy();
                        }

                        // Chart options
                        function chartOptions(category) {
                            return {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: `${category} Produk per Bulan (${year})`,
                                    },
                                },
                                scales: {
                                    x: {
                                        stacked: false,
                                    },
                                    y: {
                                        stacked: false,
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: category,
                                        },
                                    },
                                },
                            }
                        };

                        // Chart dataset
                        const datasetQty = [{
                                label: 'Qty Hijau',
                                data: qtyHijau,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Qty Jepang (JP)',
                                data: qtyJp,
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Qty CTC',
                                data: qtyCtc,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Qty Hitam',
                                data: qtyHitam,
                                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Total Qty',
                                data: qtyTotal,
                                type: 'line', // Add a line overlay for total
                                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: false,
                            },
                        ];

                        const datasetRp = [{
                                label: 'Rp Hijau',
                                data: rpHijau,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Rp Jepang (JP)',
                                data: rpJp,
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Rp CTC',
                                data: rpCtc,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Rp Hitam',
                                data: rpHitam,
                                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Total Rp',
                                data: rpTotal,
                                type: 'line', // Add a line overlay for total
                                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: false,
                            },
                        ];

                        monthlyQtyChart = new Chart(ctxMonthlyQty, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: datasetQty,
                            },
                            options: chartOptions('Kuantitas'),
                        });
                        monthlyRpChart = new Chart(ctxMonthlyRp, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: datasetRp,
                            },
                            options: chartOptions('Revenue'),
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
                updateProductYearly(dbSelect.value, selectedYear);
                updateProductMonthly(dbSelect.value, selectedYear);
            });

            // Event listener for db selection change
            dbSelect.addEventListener('change', function() {
                updateProductYearly(dbSelect.value, yearSelect.value);
                updateProductMonthly(dbSelect.value, yearSelect.value);
            });

            // Initialize with the selected year
            updateProductYearly(dbSelect.value, yearSelect.value);
            updateProductMonthly(dbSelect.value, yearSelect.value);
        });
    </script>
@endsection
