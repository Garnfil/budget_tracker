@extends(( auth()->user()->role = 'client' ? 'layouts.client-layout.app' : 'layouts.admin-layout.app' ))

@section('title', 'Edit Budget')

@push('component-styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('app-assets/css/plugins/pickers/daterange/daterange.css') }}">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Edit Budget</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('budgets.index') }}">Budgets</a>
                            </li>
                            <li class="breadcrumb-item active">Edit Budget
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <a href="{{ route('budgets.index') }}" class="btn btn-primary"><i class="feather icon-arrow-left"></i>
                        Back to List</a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">Invalid Fields. Please check all fields before submitting the form.</div>
                    @endif
                    <form action="{{ route('budgets.update', $budget->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Client <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control select2">
                                        <option value="">--- SELECT CLIENT ---</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" {{ $client->id == $budget->user_id ? 'selected' : null }}>{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger danger">@error('user_id'){{ $message }}@enderror</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="initial_balance" class="form-label">Initial Balance <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="currency-symbol">₱</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Initial Balance"
                                            aria-describedby="currency-symbol" name="initial_balance" value="{{ $budget->initial_balance }}">
                                    </div>
                                    <div class="text-danger danger">@error('initial_balance'){{ $message }}@enderror</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="date_duration" class="form-label">Date Duration <span class="text-danger">*</span></label>
                                    <div class='input-group'>
                                        <input type='text' class="form-control daterange" value="{{ $budget->start_date->format('m-d-Y') . ' - ' . $budget->end_date->format('m-d-Y') }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="start_date" id="start-date-field" value="{{ $budget->start_date }}">
                                    <input type="hidden" name="end_date" id="end-date-field" value="{{ $budget->end_date }}">
                                    <div class="text-danger danger">@error('start_date'){{ $message }}@enderror</div>
                                    <div class="text-danger danger">@error('end_date'){{ $message }}@enderror</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="display_name" class="form-label">Display Name</label>
                                            <input type="text" class="form-control" id="display-name-field"
                                                name="display_name" value="{{ $budget->display_name }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="desription" id="description-field" cols="30" rows="1" class="form-control">{{ $budget->description }}</textarea>
                                            <div class="text-danger danger">@error('description'){{ $message }}@enderror</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="net-disposable-income-field" class="form-label">Net Disposable Income</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="currency-symbol">₱</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Net Disposable Income"
                                            aria-describedby="currency-symbol" name="net_disposable_income" value="{{ $budget->net_disposable_income }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="net-disposable-income-field" class="form-label">Total Expenditure</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="currency-symbol">₱</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Total Expenditure"
                                            aria-describedby="currency-symbol" name="total_expenditure" value="{{ $budget->total_expenditure }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="net-disposable-income-field" class="form-label">Total Budgeted</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="currency-symbol">₱</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Total Budgeted"
                                            aria-describedby="currency-symbol" name="total_budgeted" value="{{ $budget->total_budgeted }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-primary">Save Budget</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ URL::asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('app-assets/js/scripts/forms/select/form-select2.js') }}"></script>

    {{-- Date Time Picker --}}
    <script src="{{ URL::asset('app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js') }}"></script>
    <script src="{{ URL::asset('app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ URL::asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ URL::asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ URL::asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ URL::asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ URL::asset('app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('app-assets/js/scripts/pickers/dateTime/bootstrap-datetime.js') }}"></script>
    {{-- <script src="{{ URL::asset('app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js') }}"></script> --}}
    <script>
        $('.daterange').daterangepicker({
                autoUpdateInput: false,
                minDate: new Date(),
            },
            function(start, end) {
                let startDate = start.format("YYYY-MM-DD").toString();
                let endDate = end.format("YYYY-MM-DD").toString();
                $('#start-date-field').val(startDate);
                $('#end-date-field').val(endDate);
            }
        );

        $('.daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });
    </script>
@endpush
