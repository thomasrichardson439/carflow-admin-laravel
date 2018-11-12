<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AwsHelper;
use App\Http\Controllers\Controller;
use App\Models\Car;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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