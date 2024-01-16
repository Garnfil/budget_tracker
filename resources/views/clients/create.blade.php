@extends('layouts.app')

@section('title', 'Add Client')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Add Client</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Add Client
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <a href="{{ route('clients.index') }}" class="btn btn-primary"><i class="feather icon-arrow-left"></i> Back to List</a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('clients.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label for="firstname" class="form-label">Firstname</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label for="lastname" class="form-label">Lastname</label>
                                    <input type="text" class="form-control" name="lastname" id="lastname">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label for="gender" class="form-label">Gender</label>
                                    <input type="text" class="form-control" name="gender" id="gender">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" id="address">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <input type="checkbox" name="is_verify" id="is_verify" class="switchery" data-size="xs" checked />
                                    <label for="is_verify" class="font-medium-2 text-bold-600 ml-1">Email Verified?</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button class="btn btn-primary">Save Client</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="../../../app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>
<script src="../../../app-assets/vendors/js/forms/toggle/switchery.min.js"></script>
<script src="../../../app-assets/js/scripts/forms/switch.js"></script>
@endpush