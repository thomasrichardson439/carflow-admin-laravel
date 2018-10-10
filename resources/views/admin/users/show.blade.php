<?php

/** @var $user \App\Models\User */
/** @var $profileUpdateRequest \App\Models\UserProfileUpdate */

?>

@extends('layouts.admin')

@section('content')
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item col-md-12">
            <div class="bgc-white p-20 bd">
                <div class="mT-30">
                    @if (!empty($profileUpdateRequest))
                        <h2>Profile update (from {{ $profileUpdateRequest->created_at->format('D m, Y, h:i A') }})</h2>
                        <div class="row">
                            <div class="col-md-4">
                                <h4>Current:</h4>
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" value="{{ $user->full_name }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" value="{{ $user->address }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" value="{{ $user->phone }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h4>New:</h4>
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" value="{{ $profileUpdateRequest->full_name }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="{{ $profileUpdateRequest->email }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" value="{{ $profileUpdateRequest->address }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" value="{{ $profileUpdateRequest->phone }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-row mt-5 align-items-end">
                            <a href="/admin/users" class="btn btn-primary mr-2">Back</a>

                            @if($profileUpdateRequest->status == \App\Models\UserProfileUpdate::STATUS_PENDING)
                                <form class="mr-2" action="/admin/reject-profile-changes/{{$profileUpdateRequest->id}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            @endif

                            @if($profileUpdateRequest->status === \App\Models\UserProfileUpdate::STATUS_APPROVED)
                                <div class="">
                                    <form class="" action="/admin/reject-profile-changes/{{$profileUpdateRequest->id}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Unapprove</button>
                                    </form>
                                </div>
                            @else
                                <form class="mr-2" action="/admin/approve-profile-changes/{{$profileUpdateRequest->id}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                            @endif
                        </div>

                        <hr>
                    @endif

                    <h2>Documents approval</h2>
                    <div class="form-row">
                        <div class="">
                            <h4 class="c-grey-900">Driving License</h4>
                            <div class="form-row">
                                <div class="">
                                    @if($user->drivingLicense)
                                        <img src="{{$user->drivingLicense->front}}"
                                             data-high-res-src="{{$user->drivingLicense->front}}"
                                             class="img-thumbnail preview-img gallery-items" alt="">
                                        <img src="{{$user->drivingLicense->back}}"
                                             data-high-res-src="{{$user->drivingLicense->back}}"
                                             class="img-thumbnail preview-img gallery-items" alt="">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="ml-5">
                            <h4 class="c-grey-900">TLC License</h4>
                            <div class="form-row">
                                <div class="">
                                    @if($user->tlcLicense)
                                        <img src="{{$user->tlcLicense->front}}"
                                             data-high-res-src="{{$user->tlcLicense->front}}"
                                             class="img-thumbnail preview-img gallery-items" alt="">
                                        <img src="{{$user->tlcLicense->back}}"
                                             data-high-res-src="{{$user->tlcLicense->back}}"
                                             class="img-thumbnail preview-img gallery-items" alt="">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="c-grey-900">Approved Ridesharing Applications</h4>
                        <h6>{{ $user->ridesharing_apps }}</h6>
                    </div>

                    <div class="form-row mt-5 align-items-end">
                        <a href="/admin/users" class="btn btn-primary mr-2">Back</a>

                        @if($user->status == \ConstUserStatus::PENDING)
                            <form class="mr-2" action="/admin/reject/{{$user->id}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        @endif

                        @if($user->status === \ConstUserStatus::APPROVED)
                            <div class="">
                                <form class="" action="/admin/reject/{{$user->id}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Unapprove</button>
                                </form>
                            </div>
                        @else
                            <form class="mr-2" action="/admin/approve/{{$user->id}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
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
