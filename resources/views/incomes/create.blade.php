@extends(( auth()->user()->role == 'client' ? 'layouts.client-layout.app' : 'layouts.admin-layout.app' ))

@section('title', 'Add income')

@push('component-styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Add income</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('incomes.index') }}">Incomes</a>
                            </li>
                            <li class="breadcrumb-item active">Add Income
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <a href="{{ route('incomes.index') }}" class="btn btn-primary"><i
                            class="feather icon-arrow-left"></i>
                        Back to List</a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="bs-callout-pink callout-border-left my-1 p-1">Invalid Fields. Please check all fields before submitting the form.</div>
                    @endif
                    <form action="{{ route('incomes.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="budget-id-field" class="form-label">Budget <span class="text-danger">*</span></label>
                                    <select name="budget_id" id="budget-id-field" class="form-control">
                                        <option value=""></option>
                                        @foreach ($budgets as $budget)
                                            <option value="{{ $budget->id }}">
                                                {{ $budget->start_date->format('M d, Y') . ' - ' . $budget->end_date->format('M d, Y') }}
                                                ({{ $budget->user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger danger">
                                        @error('budget_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="income-category-field" class="form-label">Income Category <span class="text-danger">*</span></label>
                                    <select name="income_category_id" class="form-control" id="income-category-field">
                                        <option value="">--- SELECT BUDGET FIRST ---</option>
                                    </select>
                                    <div class="text-danger danger">
                                        @error('income_category_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="title-field" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title-field">
                                    <div class="text-danger danger">
                                        @error('title')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="amount-field" class="form-label">Amount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="currency-symbol">₱</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Amount"
                                            aria-describedby="currency-symbol" name="amount" id="amount-field">
                                    </div>
                                    <div class="text-danger danger">
                                        @error('amount')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="transaction-datetime-field" class="form-label">Transaction DateTime <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="transaction_datetime" id="transaction-datetime-field" class="form-control">
                                    <div class="text-danger danger">
                                        @error('transaction_datetime')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="description-field" class="form-label">Description</label>
                                    <textarea name="description" id="description-field" cols="30" rows="2" class="form-control"></textarea>
                                    <div class="text-danger danger">
                                        @error('description')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-primary">Save Income</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ URL::asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('app-assets/js/scripts/forms/select/form-select2.js') }}"></script>

    <script>
        $('#budget-id-field').select2({
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: "Select Budget",
        });
        
        $("#income-category-field").select2({
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: "Select Budget First",
        });

        $('#budget-id-field').on('change', function(e) {
            let budget_id = e.target.value;

            $.ajax({
                url: `{{ route('income-categories.lookup', '') }}/${budget_id}?type=budget`,
                method: "GET",
                success: function (data) {
                    data.income_categories.forEach(income_category => {
                        var newOption = new Option(income_category.name, income_category.id, true, true);
                        $('#income-category-field').append(newOption).trigger('change');
                    });
                }
            })
        })
    </script>
@endpush
