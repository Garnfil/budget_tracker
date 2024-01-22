@extends(auth()->user()->role == 'client' ? 'layouts.client-layout.app' : 'layouts.admin-layout.app')

@section('title', 'Profile')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Profile</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Profile
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="bs-callout-pink callout-border-left my-1 p-1">Invalid Fields. Please check all fields
                            before submitting the form.</div>
                    @endif
                    <form action="{{ route('profile.put', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name-field" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name-field"
                                        value="{{ $user->name }}">
                                    <div class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="email-field" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email" id="email-field"
                                        value="{{ $user->email }}" readonly>
                                    <div class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if($user->role == 'client')
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="gender-field" class="form-label">Gender</label>
                                        <select name="gender" id="gender-field" class="form-control">
                                            <option value="Male"
                                                {{ $user->client_details->gender == 'Male' ? 'selected' : null }}>Male</option>
                                            <option value="Female"
                                                {{ $user->client_details->gender == 'Female' ? 'selected' : null }}>Female
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="address-field" class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address" id="address-field"
                                            value="{{ $user->client_details->address }}">
                                    </div>
                                </div>  
                            @endif
                        </div>
                        <hr>
                        <button class="btn btn-primary">Save Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
