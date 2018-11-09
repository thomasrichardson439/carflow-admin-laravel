@php

/** @var $car \App\Models\Car */

@endphp

@extends('layouts.admin')

@section('content')

    <div class="container-fluid container-admin-form">
        <div class="row">
            <div class="col-md-11 col-sm-12 col-lg-10">
                <div class="row mb-3">
                    <div class="col-6">
                        <h1 class="title">
                            <a href="{{ url('admin/cars') }}">Cars</a>
                            <i class="fa fa-caret-right"></i>
                            {{ $car->manufacturer->name }} {{ $car->model }}
                            <small>
                                ID {{ $car->id }}
                            </small>
                        </h1>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <div class="edit-off edit-buttons">
                            <a href="#" class="btn btn-gray" id="edit">Edit</a>
                            <a href="#" class="btn btn-gray">Delete</a>
                        </div>
                        <div class="edit-on edit-buttons">
                            <p class="muted edit-has-changes">Unsaved changes</p>

                            <a href="#" class="btn btn-gray" id="cancelChanges">Cancel</a>
                            <a href="#" class="btn btn-danger" id="save" data-form="#car-info">Save</a>
                        </div>
                    </div>
                </div>

                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success')}}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <b>Errors found while validating your request:</b>
                        <ul>
                            {!! implode('', $errors->all('<li>:message</li>')) !!}
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#car-availability">Availability</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#car-info">Information</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <form action="{{ url('/admin/cars/' . $car->id) }}" method="post" id="car-info">
                    {{csrf_field()}}
                    {{ method_field('PATCH') }}

                    <div class="tab-content">

                        <div class="tab-pane" id="car-availability">
                            @include('admin.cars._availability')
                        </div>

                        <div class="tab-pane active" id="car-info">
                            @include('admin.cars._info')
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection