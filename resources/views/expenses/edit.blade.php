@extends('layouts.admin-layout.app')

@section('title', 'Edit Expense')

@push('component-styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Edit Expense</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Expenses</a>
                            </li>
                            <li class="breadcrumb-item active">Edit Expense
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <a href="{{ route('expenses.index') }}" class="btn btn-primary"><i
                            class="feather icon-arrow-left"></i>
                        Back to List</a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('expenses.update', $expense->id) }}" method="post">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="budget-id-field" class="form-label">Budget <span class="text-danger">*</span></label>
                                    <select name="budget_id" id="budget-id-field" class="form-control">
                                        <option value=""></option>
                                        @foreach ($budgets as $budget)
                                            <option value="{{ $budget->id }}" {{ $budget->id == $expense->budget_id ? 'selected' : null }}>
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
                                    <label for="expense-category-field" class="form-label">Expense Category <span class="text-danger">*</span></label>
                                    <select name="expense_category_id" data-id="{{ $expense->expense_category_id }}" class="form-control" id="expense-category-field">
                                        <option value="">--- SELECT BUDGET FIRST ---</option>
                                    </select>
                                    <div class="text-danger danger">
                                        @error('expense_category_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="title-field" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title-field" value="{{ $expense->title }}">
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
                                            aria-describedby="currency-symbol" name="amount" value="{{ $expense->amount }}">
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
                                    <label for="description-field" class="form-label">Description</label>
                                    <textarea name="description" id="description-field" cols="30" rows="1" class="form-control">{{ $expense->description }}</textarea>
                                    <div class="text-danger danger">
                                        @error('description')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="transaction-datetime-field" class="form-label">Transaction DateTime <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="transaction_datetime" id="transaction-datetime-field" class="form-control" value="{{ $expense->transaction_datetime }}">
                                    <div class="text-danger danger">
                                        @error('transaction_datetime')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-primary">Save Expense</button>
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
        
        $("#expense-category-field").select2({
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: "Select Budget First",
        });

        $('#budget-id-field').on('change', function(e) {
            let budget_id = e.target.value;
            fetchExpenseCategoriesByBudget(budget_id);
        })

        $(document).ready(function() {
            let budget_id = $('#budget-id-field').val();
            fetchExpenseCategoriesByBudget(budget_id);
        })

        function fetchExpenseCategoriesByBudget(budget_id) {
            $.ajax({
                url: `{{ route('expense-categories.lookup', '') }}/${budget_id}?type=budget`,
                method: "GET",
                success: function (data) {
                    let selected_expense_category_id = $('#expense-category-field').attr('data-id');
                    data.expense_categories.forEach(expense_category => {
                        var newOption = new Option(expense_category.name, expense_category.id, true, selected_expense_category_id == expense_category.id);
                        $('#expense-category-field').append(newOption).trigger('change');
                    });
                }
            })
        }
    </script>
@endpush
