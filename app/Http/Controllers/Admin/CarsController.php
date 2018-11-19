<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AwsHelper;
use App\Http\Controllers\Controller;
use App\Models\Borough;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\CarManufacturer;
use Illuminate\Http\Request;
use Woo\GridView\DataProviders\EloquentDataProvider;

class CarsController extends Controller
{
    /**
     * @var AwsHelper
     */
    private $awsHelper;

    public function __construct()
    {
        $this->awsHelper = new AwsHelper();
    }

    public function index()
    {
        $dataProvider = new EloquentDataProvider(
            Car::query()->orderBy('id', 'ASC')
        );

        return view('admin.cars.index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cars.create', [
            'carCategories' => CarCategory::all(),
            'carManufacturers' => CarManufacturer::all(),
            'boroughs' => Borough::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required|integer|exists:car_categories,id',
            'manufacturer_id' => 'required|integer|exists:car_manufacturers,id',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . date('Y'),
            'seats' => 'required|integer|max:10',
            'owner' => 'required|string|max:255',
            'policy_number' => 'string|max:255|nullable',
            'image' => 'required|image',
            'color' => 'required|string|max:255',
            'plate' => 'required|string|max:255',
            'allowed_recurring' => 'required|boolean',

            'return_location_lat' => 'required|numeric',
            'return_location_lon' => 'required|numeric',
            'full_return_location' => 'required|string|max:255',

            'pickup_location_lat' => 'required|numeric',
            'pickup_location_lon' => 'required|numeric',
            'full_pickup_location' => 'required|string|max:255',
        ]);

        $car = new Car();
        $car->fill(array_merge(
            $request->all(),
            ['image_s3_url' => '']
        ));

        $car->saveOrFail();

        $car->image_s3_url = $this->awsHelper->uploadToS3(
            $request->file('image'),
            'cars/' . $car->id
        );

        $car->save();

        return redirect('/admin/cars/' . $car->id)->with('success', 'Car successfully created');
    }

    /**
     * Display the specified car in admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::query()->findOrFail($id);

        return view('admin.cars.show', [
            'car' => $car,
            'carCategories' => CarCategory::all(),
            'carManufacturers' => CarManufacturer::all(),
            'boroughs' => Borough::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {
        $car = Car::query()->findOrFail($id);

        $this->validate($request, [
            'category_id' => 'required|integer|exists:car_categories,id',
            'manufacturer_id' => 'required|integer|exists:car_manufacturers,id',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . date('Y'),
            'seats' => 'required|integer|max:10',
            'owner' => 'required|string|max:255',
            'policy_number' => 'string|max:255|nullable',
            'image' => 'image|nullable',
            'color' => 'required|string|max:255',
            'plate' => 'required|string|max:255',
            'allowed_recurring' => 'required|boolean',

            'return_location_lat' => 'required|numeric',
            'return_location_lon' => 'required|numeric',
            'full_return_location' => 'required|string|max:255',

            'pickup_location_lat' => 'required|numeric',
            'pickup_location_lon' => 'required|numeric',
            'full_pickup_location' => 'required|string|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image_s3_url'] = $this->awsHelper->replaceS3File(
                $car->image_s3_url,
                $request->file('image'),
                'cars/' . $car->id
            );
        }

        $car->fill($data);
        $car->saveOrFail();

        return redirect()->back()->with('success', 'Car successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}