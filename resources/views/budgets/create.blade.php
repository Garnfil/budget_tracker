@extends('layouts.app')

@section('title', 'Add Budget')

@push('component-styles')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
@endpush

@section('content')  
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">Add Budget</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('budgets.index') }}">Budgets</a>
                        </li>
                        <li class="breadcrumb-item active">Add Budget
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <a href="{{ route('budgets.index') }}" class="btn btn-primary"><i class="feather icon-arrow-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('budgets.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User</label>
                                <select name="user_id" id="user_id" class="form-control select2">

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            
                        </div>
                    </div>
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