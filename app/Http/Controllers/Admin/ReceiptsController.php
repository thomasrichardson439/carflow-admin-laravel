<?php

namespace App\Http\Controllers\Admin;

use App\Models\BookingReceipt;
use Illuminate\Http\Request;
use Woo\GridView\DataProviders\EloquentDataProvider;

class ReceiptsController
{
    public function index()
    {
        $dataProvider = new EloquentDataProvider(
            BookingReceipt::query()->orderBy('id', 'ASC')
        );

        return view('admin.receipts.index', [
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
        $car = BookingReceipt::query()->findOrFail($id);

        return view('admin.receipts.show', [
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
        $car = BookingReceipt::query()->findOrFail($id);

        return redirect()->back()->with('success', 'User successfully updated');
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