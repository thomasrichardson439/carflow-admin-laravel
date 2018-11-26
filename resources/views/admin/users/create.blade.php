@extends('layouts.admin')

@section('content')

    <form action="{{ url('/admin/users/') }}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="container-fluid container-admin-form">
            <div class="row">
                <div class="col-6 offset-3">
                    <h1 class="title">Add new user</h1>

                    @include('admin._alerts')

                    <div class="row">
                        <div class="col-12">
                            <h3>Personal information</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-card">
                                <h4>Name</h4>
                                <div class="form-group">
                                    <label>Full name</label>
                                    <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-card">
                                <h4>Address</h4>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-card">
                                <h4>Contact</h4>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-card">
                                <h4>Password</h4>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" value="{{ old('password') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h3>Driving information</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-card">
                                <h4>Driving License</h4>

                                <div class="form-group">
                                    <label>Front side</label>
                                    <input type="file" name="driving_license_front">
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label>Back side</label>
                                    <input type="file" name="driving_license_back">
                                </div>
                            </div>

                            <div class="form-card">
                                <h4>TLC License</h4>

                                <div class="form-group">
                                    <label>Front side</label>
                                    <input type="file" name="tlc_license_front">
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label>Back side</label>
                                    <input type="file" name="tlc_license_back">
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-card">
                                <h4>Ridesharing Apps</h4>
                                <ul class="fa-ul apps-list">
                                    @foreach (old('ridesharing_app', $defaultApps) as $app)
                                        <li>
                                            <label class="d-flex align-items-center">
                                                <input class="apple-switch mR-10"
                                                       type="checkbox" name="ridesharing_apps[{{ $app }}]"
                                                       value="{{ $app }}"
                                                >
                                                {{ $app }}
                                            </label>
                                        </li>
                                    @endforeach
                                    <li>
                                        <input type="text" class="form-control" placeholder="Specify other apps" name="ridesharing_app_additional">
                                        <p class="muted small">Separate multiple by comma</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{ url('/admin/users') }}" class="btn btn-gray">Cancel</a>
                            <button type="submit" class="btn btn-danger">Add new user</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection