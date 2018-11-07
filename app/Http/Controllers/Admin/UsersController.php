<?php

namespace App\Http\Controllers\Admin;

use App\Mail\UserProfileReviewNotification;
use App\Models\Booking;
use App\Models\UserProfileUpdate;
use Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Woo\GridView\DataProviders\EloquentDataProvider;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Mail\UserRegistrationReviewNotification;

/**
 * Class UsersController
 * @package App\Http\Controllers\Admin
 */
class UsersController extends Controller
{
    /**
     * Display a listing of the users in admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataProvider = new EloquentDataProvider(
            User::query()->where('admin', 0)
                ->with('profileUpdateRequest')
                ->orderBy('id', 'ASC')
        );

        return view('admin.users.index', [
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
     * Display the specified user in admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', [
            'user' => $user,
            'profileUpdateRequest' => $user->profileUpdateRequest,
            'recurringBookingsProvider' => new EloquentDataProvider(
                $user->bookings()
                    ->getQuery()
                    ->where('is_recurring', true)
            ),
            'oneTimeBookingsProvider' => new EloquentDataProvider(
                $user->bookings()
                    ->getQuery()
                    ->where('is_recurring', false)
            ),
            'averageBookingTime' => Booking::query()
                ->where('user_id', $user->id)
                ->average(\DB::raw('booking_ending_at - booking_starting_at')) / (60 * 60),
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
        $user = User::findOrFail($id);

        $this->validate($request, [
            'full_name' => 'required|string|max:255',
            'email' => 'required|unique:users,email,' . $user->id . '|email',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
            'ridesharing_apps' => 'array',
            'ridesharing_apps.*' => 'string',
            'ridesharing_app_additional' => 'string|nullable',
            'driving_license_front' => 'image',
            'driving_license_back' => 'image',
            'tlc_license_front' => 'image',
            'tlc_license_back' => 'image',
        ]);

        $apps = $request->ridesharing_apps ?? [];

        if (!empty($request->ridesharing_app_additional)) {
            $apps = array_merge(
                $apps,
                array_filter(array_map('trim', explode(',', $request->ridesharing_app_additional)))
            );
        }

        $user->fill($request->all());
        $user->ridesharing_apps = implode(', ', $apps);
        $user->saveOrFail();

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


    /**
     * Reject profile changes
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectProfileChanges($id)
    {
        $update = UserProfileUpdate::query()->findOrFail($id);

        $update->setAttribute('status', UserProfileUpdate::STATUS_REJECTED)->save();

        Mail::to($update->user->email)->send(new UserProfileReviewNotification($update->status));

        return redirect()->route('admin.users.index');
    }

    /**
     * Approves profile changes
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveProfileChanges($id)
    {
        $update = UserProfileUpdate::query()->findOrFail($id);

        $update->setAttribute('status', UserProfileUpdate::STATUS_APPROVED)->save();

        if (!empty($update->full_name)) {
            $update->user->full_name = $update->full_name;
        }

        if (!empty($update->email)) {
            $update->user->email = $update->email;
        }

        if (!empty($update->phone)) {
            $update->user->phone = $update->phone;
        }

        if (!empty($update->address)) {
            $update->user->address = $update->address;
        }

        $update->user->save();

        Mail::to($update->user->email)->send(new UserProfileReviewNotification($update->status));

        return redirect()->route('admin.users.index');
    }

    /**
     * Reject user documents
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rejectDocuments($id)
    {
        $user = User::findOrFail($id);
        $user->status = \ConstUserStatus::REJECTED;
        $user->documents_uploaded = 0;
        $user->save();

        Mail::to($user->email)->send(new UserRegistrationReviewNotification($user->status));

        return redirect()->route('admin.users.index');
    }

    /**
     * Approve user documents
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approveDocuments($id)
    {
        $user = User::findOrFail($id);
        $user->status = \ConstUserStatus::APPROVED;
        $user->documents_uploaded = 1;
        $user->save();

        Mail::to($user->email)->send(new UserRegistrationReviewNotification($user->status));

        return redirect()->route('admin.users.index');
    }
}
