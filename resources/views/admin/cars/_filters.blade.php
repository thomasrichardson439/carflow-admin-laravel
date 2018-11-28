<form id="filters-form">
    <b>Filter</b>
    <div class="row filters-list">
        <div class="col-4">
            <div class="filter" data-filter="manufacturer_id">
                <label class="text-muted">Car maker</label>
                <select name="manufacturer_id[]" class="select2 form-control" multiple>
                    @foreach ($carManufacturers as $manufacturer)
                        <option value="{{ $manufacturer->id }}">
                            {{ $manufacturer->name }}
                        </option>
                    @endforeach
                </select>

                <i class="fa fa-times removeFilter"></i>
            </div>

            <div class="filter" data-filter="model">
                <label class="text-muted">Car model</label>
                <input name="model" class="form-control">

                <i class="fa fa-times removeFilter"></i>
            </div>

            <div class="filter" data-filter="year">
                <label class="text-muted">Year of production</label>
                <select name="year[]" class="select2 form-control" multiple>
                    @foreach ($years as $year)
                        <option>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>

                <i class="fa fa-times removeFilter"></i>
            </div>

            <div class="filter" data-filter="seats">
                <label class="text-muted">Number of seats</label>
                <select name="seats[]" class="select2 form-control" multiple>
                    @foreach ($seats as $amount)
                        <option>
                            {{ $amount }}
                        </option>
                    @endforeach
                </select>

                <i class="fa fa-times removeFilter"></i>
            </div>

            <div class="filter" data-filter="owner">
                <label class="text-muted">Car owner</label>
                <input name="owner" class="form-control">

                <i class="fa fa-times removeFilter"></i>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-12">
        <div class="dropdown">
            <button class="btn btn-gray dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Add filter
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="filters-menu">
                <a class="dropdown-item" href="#" data-filter="manufacturer_id">Car maker</a>
                <a class="dropdown-item" href="#" data-filter="model">Car model</a>
                <a class="dropdown-item" href="#" data-filter="year">Year of production</a>
                <a class="dropdown-item" href="#" data-filter="seats">Number of seats</a>
                <a class="dropdown-item" href="#" data-filter="owner">Car owner</a>
            </div>
        </div>
    </div>
</div>