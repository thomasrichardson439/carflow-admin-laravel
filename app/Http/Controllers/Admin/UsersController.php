<?php

namespace App\Http\Controllers\Admin;

use Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Mail\DocumentsReviewNotification;

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
        return Datatables::of(User::where('admin', 0))->make(true);
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
     * Reject user documents
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rejectDocuments($id)
    {
         $user = User::findOrFail($id);
         $user->status = 'rejected';
         $user->documents_uploaded = 0;
         $user->save();

         // Mail::to($user->email)->send(new DocumentsReviewNotification(0));

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
        $user->status = 'approved';
        $user->documents_uploaded = 1;
        $user->save();

        // Mail::to($user->email)->send(new DocumentsReviewNotification(1));

        return redirect()->route('admin.users.index');
    }
}
