<?php

namespace App\Http\Controllers\Admin;

use Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Mail\UserReviewNotification;

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
        return view('admin.users.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function usersData()
    {
        return Datatables::of(
            User::query()->where('admin', 0)->orderBy('id', 'ASC')

        )->make(true);
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

        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    public function rejectProfile($id)
    {
        $user = User::findOrFail($id);
        $user->status = \ConstUserStatus::REJECTED_PROFILE;
        $user->save();

        Mail::to($user->email)->send(new UserReviewNotification($user->status));

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

        Mail::to($user->email)->send(new UserReviewNotification($user->status));

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

        Mail::to($user->email)->send(new UserReviewNotification($user->status));

        return redirect()->route('admin.users.index');
    }
}
