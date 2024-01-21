@extends('layouts.admin-layout.app')

@section('title', 'Clients')

@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Clients</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Clients
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <a href="{{ route('clients.create') }}" class="btn btn-primary">Add Client <i class="feather icon-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="search-text-field" placeholder="Search...">
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('sections.datatable_js')
    <script>

        $('#client-table').on('preXhr.dt', function(e, setting, data) {
            var searchText = $('#search-text-field').val();

            data['searchText'] = searchText;
        });

        function showTable() {
            window.LaravelDataTables['client-table'].draw(false);
        }

        $('#search-text-field').on('input', function(e) {
            showTable();
        })
    </script>
@endpush
