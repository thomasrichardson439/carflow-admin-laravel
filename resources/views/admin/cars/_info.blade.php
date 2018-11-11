<div class="row">
    <div class="col-4">
        <div class="form-card">
            <h4>Maker and model</h4>

            <div class="form-group">
                <label>Category</label>
                <select name="manufacturer_id" class="form-control select2">
                    @foreach (\App\Models\CarCategory::all() as $category)
                        <option @if (old('category_id', $car->category_id) == $category->id) selected @endif
                        value="{{ $category->id }}"
                        >{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Car maker</label>
                <select name="manufacturer_id" class="form-control select2">
                    @foreach (\App\Models\CarManufacturer::all() as $manufacturer)
                        <option @if (old('manufacturer_id', $car->manufacturer_id) == $manufacturer->id) selected @endif
                                value="{{ $manufacturer->id }}"
                        >{{ $manufacturer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Car model</label>
                <input type="text" name="model" value="{{ old('model', $car->model) }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Year of production</label>
                <input type="text" name="year" value="{{ old('year', $car->year) }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Number of seats</label>
                <input type="text" name="seats" value="{{ old('seats', $car->seats) }}" class="form-control">
            </div>
        </div>

        <div class="form-card">
            <h4>Car owner</h4>
            <div class="form-group">
                <label>Car owner</label>
                <input type="text" name="owner" value="{{ old('owner', $car->owner) }}" class="form-control">
            </div>
        </div>

        <div class="form-card">
            <h4>Policy</h4>
            <div class="form-group">
                <label>Policy number</label>
                <input type="text" name="policy_number" value="{{ old('policy_number', $car->policy_number) }}" class="form-control">
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
                                    <input type="text" name="pickup_location_lat" value="{{ old('pickup_location_lat', $car->pickup_location_lat) }}" class="form-control">
                                </div>

                                <div class="form-group col-6">
                                    <label>Lon</label>
                                    <input type="text" name="pickup_location_lon" value="{{ old('pickup_location_lon', $car->pickup_location_lon) }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Full address</label>
                                <input type="text" name="full_pickup_location" value="{{ old('full_pickup_location', $car->full_pickup_location) }}" class="form-control">
                            </div>
                        </div>

                        <div class="tab-pane" id="tab-return">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Lat</label>
                                    <input type="text" name="return_location_lat" value="{{ old('return_location_lat', $car->return_location_lat) }}" class="form-control">
                                </div>

                                <div class="form-group col-6">
                                    <label>Lon</label>
                                    <input type="text" name="return_location_lon" value="{{ old('return_location_lon', $car->return_location_lon) }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Full address</label>
                                <input type="text" name="full_return_location" value="{{ old('full_return_location', $car->full_return_location) }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-card">
                    <h4>Usage</h4>

                    <div class="info">
                        <p class="title">Total miles traveled</p>
                        <p class="content">&mdash;mi</p>
                    </div>

                    <div class="info">
                        <p class="title">Avg Miles traveled per day</p>
                        <p class="content">&mdash;mi/day</p>
                    </div>

                    <div class="info">
                        <p class="title">Avg speed</p>
                        <p class="content">&mdash;mi/h</p>
                    </div>

                    <div class="info">
                        <p class="title">Number of viloations</p>
                        <p class="content">&mdash;</p>
                    </div>

                    <div class="info">
                        <p class="title">Damages</p>
                        <p class="content">0</p>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="form-card">
                    <h4>Status</h4>

                    <div class="info">
                        <p class="title">Ignition</p>
                        <p class="content success">Unknown</p>
                    </div>

                    <div class="info">
                        <p class="title">Oil change</p>
                        <p class="content danger">Unknown</p>
                    </div>

                    <div class="info">
                        <p class="title">Tire change</p>
                        <p class="content danger">Unknown</p>
                    </div>

                    <div class="info">
                        <p class="title">Tire change</p>
                        <p class="content danger">Unknown</p>
                    </div>

                    <div class="info">
                        <p class="title">GPS Tracking</p>
                        <p class="content"><a href="#">Track car</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>