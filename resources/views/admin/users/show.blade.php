@php

/** @var $user \App\Models\User */
/** @var $profileUpdateRequest \App\Models\UserProfileUpdate */


if ($user->profileUpdateRequest && $user->profileUpdateRequest->status == \App\Models\UserProfileUpdate::STATUS_PENDING) {
    $updateRequest = $user->profileUpdateRequest;
} else {
    $updateRequest = null;
}

@endphp

@extends('layouts.admin')

@section('content')

    <div class="container-fluid container-admin-form">
        <div class="row">
            <div class="col-md-11 col-sm-12 col-lg-10">
                <div class="row mb-3">
                    <div class="col-6">
                        <h1 class="title">
                            <a href="{{ url('admin/users') }}">Drivers</a>
                            <i class="fa fa-caret-right"></i>
                            {{ $user->full_name }}
                            <small>
                                ID {{ $user->id }}

                                @if ($user->status == 'pending')
                                    <span class="admin-label label-warning">Pending</span>

                                @elseif ($user->status == 'rejected')
                                    <span class="admin-label label-danger">Rejected</span>

                                @elseif ($user->profileUpdateRequest !== null && $user->profileUpdateRequest->status == 'pending')
                                    <span class="admin-label label-warning">Profile Pending</span>

                                @elseif ($user->profileUpdateRequest !== null && $user->profileUpdateRequest->status == 'rejected')
                                    <span class="admin-label label-warning">Profile Rejected</span>
                                @else
                                    <span class="admin-label label-success">Approved</span>
                                @endif
                            </small>
                        </h1>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <div class="edit-off edit-buttons">
                            <a href="#" class="btn btn-gray" id="edit">Edit</a>

                            <form action="{{ url('/admin/users/' . $user->id) }}" method="post">
                                {{csrf_field()}}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-gray" id="delete">Delete</button>
                            </form>
                        </div>
                        <div class="edit-on edit-buttons">
                            <p class="muted edit-has-changes">Unsaved changes</p>

                            <a href="#" class="btn btn-gray" id="cancelChanges">Cancel</a>
                            <a href="#" class="btn btn-danger" id="save" data-form="#user-form">Save</a>
                        </div>
                    </div>
                </div>

                @include('admin._alerts')

                @if ($user->status == \App\Models\User::STATUS_PENDING)
                    <div class="alert alert-soft-danger mb-3">
                        <div class="row">
                            <div class="col-6">
                                <h3>Pending account approval</h3>
                                <p>Account was created {{ $user->created_at->diffForHumans(now(), true) }} ago and waiting for your approval</p>
                            </div>
                            <div class="col-6 d-flex justify-content-end align-items-center">
                                <form action="/admin/users/{{$user->id}}/approve" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success mR-10">Accept user</button>
                                </form>

                                <form action="/admin/users/{{$user->id}}/reject" method="post">
                                    @csrf
                                    <a href="#" class="btn btn-light-gray" data-toggle="modal" data-target="#reject-registration">Reject user</a>
                                    @include('admin.users.modals._reject', ['modalId' => 'reject-registration'])
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                @if (!empty($updateRequest))
                    <div class="alert alert-soft-danger mb-3">
                        <div class="row">
                            <div class="col-6">
                                <h3>Pending profile changes approval</h3>
                                <p>Request was made {{ $updateRequest->created_at->diffForHumans(now(), true) }} ago and waiting for your approval</p>
                            </div>
                            <div class="col-6 d-flex justify-content-end align-items-center">
                                <form action="/admin/users/{{$updateRequest->id}}/approve-profile-changes" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success mR-10">Approve changes</button>
                                </form>

                                <form action="/admin/users/{{$updateRequest->id}}/reject-profile-changes" method="post">
                                    @csrf
                                    <a href="#" class="btn btn-light-gray" data-toggle="modal" data-target="#reject-changes">Reject changes</a>
                                    @include('admin.users.modals._reject', ['modalId' => 'reject-changes'])
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link {!! app('request')->input('booking') == 1 ? "active" : "" !!}" data-toggle="tab" href="#user-bookings">Bookings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  {!! app('request')->input('booking') == 1 ? "" : "active" !!}" data-toggle="tab" href="#user-info">Information</a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="tab-content">

                    <div class="tab-pane {!! app('request')->input('booking') == 1 ? "active" : "" !!}" id="user-bookings">
                        @include('admin.users._bookings')
                    </div>

                    <div class="tab-pane  {!! app('request')->input('booking') == 1 ? "" : "active" !!}" id="user-info">
                        <form action="{{ url('/admin/users/' . $user->id) }}" method="post" id="user-form" enctype="multipart/form-data">
                            {{csrf_field()}}
                            {{ method_field('PATCH') }}

                            @include('admin.users._form')
                            @include('admin.users._info')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.users.modals._ride_photos')
    @include('admin.users.modals._receipts')
    @include('admin.users.modals._issue_reports')
    @include('admin.users.modals._booked_cars')

@endsection

@push('styles')
    <link rel="stylesheet" href="/css/imageviewer.css">
@endpush

@push('scripts')
    <script src="/js/imageviewer.js"></script>
    <script type="text/javascript">
        $(function () {
            var viewer = ImageViewer();
            $('.gallery-items').click(function () {
                var imgSrc = this.src,
                    highResolutionImage = $(this).data('high-res-img');
                viewer.show(imgSrc, highResolutionImage);
            });
        });
    </script>
@endpush
