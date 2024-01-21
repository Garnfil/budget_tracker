@extends('layouts.client-layout.app')

@section('title', 'Client Dashboard')

@section('content')
    <div class="container">
        <div class="content-wrapper px-1" style="height: 100%;">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">Dashboard</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="btn-group mr-1 mb-1">
                    <button type="button" data-id="{{ $current_budget->id }}"
                        class="btn btn-outline-secondary" id="current-budget-btn">{{ $current_budget->start_date->format('M d, Y') . ' - ' . $current_budget->end_date->format('M d, Y') }}</button>
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only"></span>
                    </button>
                    <div class="dropdown-menu">
                        <input type="hidden" id="current-budget-field" value="{{ $current_budget->id }}">
                        @forelse ($budgets as $budget)
                            <a class="dropdown-item budget-dropdown {{ $budget->id == $current_budget->id ? 'active' : null }}" data-id="{{ $budget->id }}"
                                href="javascript:void(0)"><i class="fa fa-calendar mr-1"></i> {{ $budget->start_date->format('M d, Y') . ' - ' . $budget->end_date->format('M d, Y') }}</a>
                        @empty
                            <a class="dropdown-item" href="#">No other budgets found</a>
                        @endforelse
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-lg-8">
                                <div class="row" style="gap: 10px;">
                                    <div class="col-lg-5 p-2 border rounded">
                                        <h2 class="text-primary">₱ <span class="net-disposable-income-text"></span></h2>
                                        <h6>Net Disposable Income</h6>
                                    </div>
                                    <div class="col-lg-5 p-2 border rounded">
                                        <h2 class="text-primary">₱ <span class="total-expenditure-text"></span></h2>
                                        <h6>Total Expenditure</h6>
                                    </div>
                                    <div class="col-lg-5 p-2 border rounded">
                                        <h2 class="text-primary">₱ <span class="total-budgeted-text"></span></h2>
                                        <h6>Total Budgeted</h6>
                                    </div>
                                    <div class="col-lg-5 p-2 border">
                                        <h2 class="text-primary">₱ <span class="remaining-to-spend-text"></span></h2>
                                        <h6>Remaining to Spend</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <h2>Budget</h2>
                                <div id="general_task_radial_bar_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var general_task_radial_bar_chart_options = {
            chart: {
                height: 300,
                width: 350,
                type: 'radialBar',
                offsetY: 30,
                toolbar: {
                    show: false
                }
            },

            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: '80%',
                    },
                    track: {
                        background: '#eee',
                        strokeWidth: '80%',
                        margin: 0, // margin is in pixels

                    },

                    dataLabels: {
                        showOn: 'always',
                        name: {
                            show: false,
                        },
                        value: {
                            formatter: function(val) {
                                return parseInt(val) + '%';
                            },
                            offsetY: 8,
                            color: "#00b5b8",
                            fontSize: '20px',
                            show: true,
                        }
                    }
                }
            },
            responsive: [{
                breakpoint: 768,
                options: {
                    chart: {
                        width: 320,
                        offsetX: -15
                    },
                    legend: {
                        show: false
                    }
                }
            }],
            fill: {
                colors: ["#00b5b8"]
            },
            series: [67],
            stroke: {
                lineCap: 'flat'
            },
            labels: ['Percent'],

        }

        var general_task_radial_bar_chart = new ApexCharts(
            document.querySelector("#general_task_radial_bar_chart"),
            general_task_radial_bar_chart_options
        );

        general_task_radial_bar_chart.render();
    </script>

    <script>
        $('.budget-dropdown').on('click', function(e) {
            let budget_id = $(e.target).attr('data-id');
            fetchAllBudgetInfo(budget_id);

            $('.budget-dropdown').removeClass('active');
            $(e.target).addClass('active');
        });

        $(document).ready(function() {
            let budget_id = $('#current-budget-field').val();
            fetchAllBudgetInfo(budget_id);
        })

        function fetchAllBudgetInfo(budget_id) {
            let main_url = "{{ route('budgets.all-info', '') }}";
            $.ajax({
                url: main_url + '/' + budget_id,
                method: "GET",
                success: function(data) {
                    let formattedStartDate = formatDate(data.budget.start_date);
                    let formattedEndDate = formatDate(data.budget.end_date);
                    $('#current-budget-btn').text(`${formattedStartDate} - ${formattedEndDate}`);
                    $('.net-disposable-income-text').text(parseFloat(data.budget.net_disposable_income));
                    $('.total-expenditure-text').text(parseFloat(data.budget.total_expenditure))
                    $('.total-budgeted-text').text(parseFloat(data.budget.total_budgeted))
                    $('.remaining-to-spend-text').text(parseFloat(data.budget.total_budgeted) - parseFloat(data
                        .budget.total_expenditure))
                }
            });
        }

        function formatDate(dateString) {
            const dateObject = new Date(dateString);
            const day = dateObject.getDate();
            const month = dateObject.toLocaleString('en-US', { month: 'short' });
            const year = dateObject.getFullYear();

            const formattedDay = (day < 10) ? '0' + day : day;
            const formattedDate = `${month} ${formattedDay}, ${year}`;

            return formattedDate;
        }
    </script>
@endpush
