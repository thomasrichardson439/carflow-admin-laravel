@extends('layouts.admin')

@section('content')

    <form action="{{ url('/admin/cars/') }}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="container-fluid container-admin-form">
            <div class="row">
                <div class="col-8 offset-2">
                    <h1 class="title">Add new car</h1>

                    @include('admin._alerts')

                    <div class="row">
                        <div class="col-4">
                            <div class="form-card">
                                <h4>Maker and model</h4>

                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category_id" class="form-control select2">
                                        @foreach ($carCategories as $category)
                                            <option @if (old('category_id') == $category->id) selected @endif
                                            value="{{ $category->id }}"
                                            >{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Car maker</label>
                                    <select name="manufacturer_id" class="form-control select2">
                                        @foreach ($carManufacturers as $manufacturer)
                                            <option @if (old('manufacturer_id') == $manufacturer->id) selected @endif
                                            value="{{ $manufacturer->id }}"
                                            >{{ $manufacturer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Car model</label>
                                    <input type="text" name="model" value="{{ old('model') }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Year of production</label>
                                    <input type="text" name="year" value="{{ old('year') }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Number of seats</label>
                                    <input type="text" name="seats" value="{{ old('seats') }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Color</label>
                                    <input type="text" name="color" value="{{ old('color') }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Plate</label>
                                    <input type="text" name="plate" value="{{ old('plate') }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="d-flex align-items-center">
                                        <input type="hidden" name="allowed_recurring" value="0">
                                        <input class="apple-switch mR-10"
                                               type="checkbox" name="allowed_recurring"
                                               value="1"
                                               checked
                                        >
                                        Allowed recurring
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label>Front photo</label>
                                    <input type="file" name="image">
                                </div>

                                <div class="form-group">
                                    <label>Car owner</label>
                                    <input type="text" name="owner" value="{{ old('owner') }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Policy number</label>
                                    <input type="text" name="policy_number" value="{{ old('policy_number') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-card">
                                        <h4>Location</h4>

                                        <div id="locationMap" style="height: 300px;"></div>

                                        <ul class="nav nav-tabs" id="location-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#tab-pickup">Pickup location</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tab-return">Return location</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content mT-10">
                                            <div class="tab-pane active" id="tab-pickup">
                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label>Lat</label>
                                                        <input type="text" name="pickup_location_lat" value="{{ old('pickup_location_lat') }}" class="form-control">
                                                    </div>

                                                    <div class="form-group col-6">
                                                        <label>Lon</label>
                                                        <input type="text" name="pickup_location_lon" value="{{ old('pickup_location_lon') }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-8">
                                                        <label>Full address</label>
                                                        <input type="text" name="full_pickup_location" value="{{ old('full_pickup_location') }}" class="form-control">
                                                    </div>

                                                    <div class="form-group col-4">
                                                        <label>Borough</label>
                                                        <select name="pickup_borough_id" class="form-control select2">
                                                            @foreach ($boroughs as $borough)
                                                                <option @if (old('pickup_borough_id') == $borough->id) selected @endif
                                                                value="{{ $borough->id }}"
                                                                >{{ $borough->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="tab-return">
                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label>Lat</label>
                                                        <input type="text" name="return_location_lat" value="{{ old('return_location_lat') }}" class="form-control">
                                                    </div>

                                                    <div class="form-group col-6">
                                                        <label>Lon</label>
                                                        <input type="text" name="return_location_lon" value="{{ old('return_location_lon') }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-8">
                                                        <label>Full address</label>
                                                        <input type="text" name="full_return_location" value="{{ old('full_return_location') }}" class="form-control">
                                                    </div>

                                                    <div class="form-group col-4">
                                                        <label>Borough</label>
                                                        <select name="return_borough_id" class="form-control select2">
                                                            @foreach ($boroughs as $borough)
                                                                <option @if (old('return_borough_id') == $borough->id) selected @endif
                                                                value="{{ $borough->id }}"
                                                                >{{ $borough->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{ url('/admin/cars') }}" class="btn btn-gray">Cancel</a>
                            <button type="submit" class="btn btn-danger">Add new user</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection