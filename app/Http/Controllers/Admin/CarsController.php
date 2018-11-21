<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AwsHelper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Borough;
use App\Models\Car;
use App\Models\CarAvailabilitySlot;
use App\Models\CarCategory;
use App\Models\CarManufacturer;
use App\Repositories\CarsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Woo\GridView\DataProviders\EloquentDataProvider;

class CarsController extends Controller
{
    /**
     * @var AwsHelper
     */
    private $awsHelper;

    /**
     * @var CarsRepository
     */
    private $carsRepository;

    public function __construct()
    {
        $this->awsHelper = new AwsHelper();
        $this->carsRepository = new CarsRepository();
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
        /**
         * @var Car $car
         */
        $car = Car::query()->findOrFail($id);

        $availability = [
            'recurring' => old('recurring', []),
            'onetime' => old('onetime', []),
        ];

        if (empty($availability['recurring'] && empty($availability['onetime']))) {
            $availability = $this->carsRepository->prepareAvailabilityView($car);
        }

        return view('admin.cars.show', [
            'car' => $car,
            'carCategories' => CarCategory::all(),
            'carManufacturers' => CarManufacturer::all(),
            'boroughs' => Borough::all(),
            'availability' => $availability,
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

            'recurring' => 'required|array',
            'onetime' => 'array',
            'deletedAvailability' => 'array',

            'recurring.*.day' => 'required|string',
            'recurring.*.hour_from' => 'required|string',
            'recurring.*.hour_to' => 'required|string',

            'onetime.*.date' => 'required|date|date_format:"m/d/Y"',
            'onetime.*.hour_from' => 'required|string',
            'onetime.*.hour_to' => 'required|string',
        ]);

        if (!$this->carsRepository->validateAvailabilityList($request->recurring, $request->get('onetime', []))) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'recurring' => ['Please check availability intervals. Seem to be some of them are interfering'],
            ]);

            throw $error;
        }

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

        $this->carsRepository->updateAvailabilities(
            $car->id,
            $request->recurring,
            $request->get('onetime', []),
            $request->get('deletedAvailability', [])
        );

        return redirect()->back()->with('success', 'Car successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        /**
         * @var Car $car
         */
        $car = Car::query()->findOrFail($id);
        $car->delete();

        $car->bookings()->where('status', Booking::STATUS_PENDING)->update([
            'status' => Booking::STATUS_CANCELED
        ]);

        return redirect('/admin/cars')->with('success', 'Car successfully deleted');
    }

}