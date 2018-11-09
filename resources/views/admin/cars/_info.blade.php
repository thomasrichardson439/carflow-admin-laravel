<div class="row">
    <div class="col-4">
        <div class="form-card">
            <h4>Maker and model</h4>
            <div class="form-group">
                <label>Car maker</label>
                <input type="text" name="manufacturer_id" value="{{ old('manufacturer_id', $car->manufacturer_id) }}" class="form-control">
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
                <input type="text" name="seats" value="{{ old('seats', 1) }}" class="form-control">
            </div>
        </div>

        <div class="form-card">
            <h4>Car owner</h4>
            <div class="form-group">
                <label>Car owner</label>
                <input type="text" name="owner" value="{{ old('owner', 'Car flo') }}" class="form-control">
            </div>
        </div>

        <div class="form-card">
            <h4>Policy</h4>
            <div class="form-group">
                <label>Policy number</label>
                <input type="text" name="policy" value="{{ old('policy', 'SNH0000000000') }}" class="form-control">
            </div>
        </div>
    </div>

    <div class="col-4">
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

    <div class="col-4">
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