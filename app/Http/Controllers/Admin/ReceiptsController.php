<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingReceipt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Woo\GridView\DataProviders\EloquentDataProvider;

class ReceiptsController extends Controller
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
        $receipt = BookingReceipt::query()->findOrFail($id);

        return view('admin.receipts.show', [
            'receipt' => $receipt,
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
        $receipt = BookingReceipt::query()->findOrFail($id);

        $data = $request->all();

        if (isset($request['hour'])) {
            $data['hour'] = ltrim($data['hour'], '0');
        }

        if (isset($request['minute'])) {
            $data['minute'] = ltrim($data['minute'], '0') ?: 0;
        }

        $this->getValidationFactory()
            ->make($data, [
                'title' => 'required|string|max:255',
                'price' => 'required|numeric',
                'location' => 'required|string|max:255',
                'date' => 'required|date|date_format:m/d/Y',
                'hour' => 'required|integer|min:1|max:12',
                'minute' => 'required|integer|min:0|max:59',
                'merediem' => 'required|in:AM,PM',
            ])
            ->validate();

        $receipt->fill($request->all());

        $receipt->receipt_date = Carbon::parse(
            $request->date . ' ' . $request->hour . ':' . $request->minute . ' ' . $request->merediem
        );

        $receipt->saveOrFail();

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
        $receipt = BookingReceipt::query()->findOrFail($id);
        $receipt->delete();

        return redirect('/admin/receipts')->with('success', 'Receipt successfully deleted');
    }

}