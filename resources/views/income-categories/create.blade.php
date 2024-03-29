@extends(( auth()->user()->role == 'client' ? 'layouts.client-layout.app' : 'layouts.admin-layout.app' ))

@section('title', 'Add Income Category')

@push('component-styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Add Income Category</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('income-categories.index') }}">Income
                                    Categories</a>
                            </li>
                            <li class="breadcrumb-item active">Add Income Category
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <a href="{{ route('income-categories.index') }}" class="btn btn-primary"><i
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
                    <form action="{{ route('income-categories.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="budget_id" class="form-label">Budget <span class="text-danger">*</span></label>
                                    <select name="budget_id" id="budget_id" class="select2">
                                        <option value="">--- SELECT BUDGET ---</option>
                                        @foreach ($budgets as $budget)
                                            <option value="{{ $budget->id }}">
                                                {{ $budget->start_date->format('M d, Y') . ' - ' . $budget->end_date->format('M d, Y') }}
                                                ( {{ $budget->user->email }} )</option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger danger">@error('budget_id'){{ $message }}@enderror</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name-field" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="" name="name" id="name-field">
                                    <div class="text-danger danger">@error('name'){{ $message }}@enderror</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="goal-amount-field" class="form-label">Goal Amount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="currency-symbol">₱</span>
                                        </div>
                                        <input type="text" class="form-control" value="" name="goal_amount" id="goal-amount-field">
                                    </div>
                                    <div class="text-danger danger">@error('goal_amount'){{ $message }}@enderror</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="note-field" class="form-label">Note</label>
                                    <textarea name="note" id="note-field" cols="30" rows="3" class="form-control"></textarea>
                                    <div class="text-danger danger">@error('note'){{ $message }}@enderror</div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-primary">Save Income Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ URL::asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
@endpush
