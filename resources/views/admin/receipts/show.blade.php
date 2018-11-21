@php

    /** @var $receipt \App\Models\BookingReceipt */

@endphp

@extends('layouts.admin')

@section('content')

    <div class="container-fluid container-admin-form">
        <div class="row">
            <div class="col-md-11 col-sm-12 col-lg-10">
                <div class="row mb-3">
                    <div class="col-6">
                        <h1 class="title">
                            <a href="{{ url('admin/receipts') }}">Receipts</a>
                            <i class="fa fa-caret-right"></i>
                            ${{ number_format($receipt->price, 2) }} {{ $receipt->title }}
                        </h1>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <div class="edit-off edit-buttons">
                            <a href="#" class="btn btn-gray" id="edit">Edit</a>
                            <form action="{{ url('/admin/receipts/' . $receipt->id) }}" method="post">
                                {{csrf_field()}}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-gray" id="delete">Delete</button>
                            </form>
                        </div>
                        <div class="edit-on edit-buttons">
                            <p class="muted edit-has-changes">Unsaved changes</p>

                            <a href="#" class="btn btn-gray" id="cancelChanges">Cancel</a>
                            <a href="#" class="btn btn-danger" id="save" data-form="#receipt-form">Save</a>
                        </div>
                    </div>
                </div>

                @include('admin._alerts')

                <form action="{{ url('/admin/receipts/' . $receipt->id) }}" method="post" id="receipt-form">
                    {{csrf_field()}}
                    {{ method_field('PATCH') }}

                    <div class="row">
                        <div class="col-4 offset-4">
                            <div class="form-card">
                                <h4>Receipt</h4>
                                <div class="form-group">
                                    <label>ID</label>
                                    <input type="text" name="title" value="{{ $receipt->id }}" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Receipt kind</label>
                                    <input type="text" name="title" value="{{ old('title', $receipt->title) }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Amount</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="price" value="{{ old('price', $receipt->price) }}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Location</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-map-marker-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="location" value="{{ old('location', $receipt->location) }}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date"
                                               value="{{ old('date', $receipt->receipt_date->format('m/d/Y')) }}"
                                               class="form-control edit-on"
                                               data-datepicker
                                        >

                                        <input type="text" value="{{ old('receipt_date', $receipt->receipt_date->format('m/d/Y')) }}" class="form-control edit-off">
                                    </div>
                                </div>

                                <div class="form-group edit-off">
                                    <label>Time</label>
                                    <input type="text" value="{{ $receipt->receipt_date->format('h:i A') }}" class="form-control">
                                </div>

                                <div class="form-group edit-on">
                                    <label>Time</label>
                                    <div class="row">
                                        <div class="col-6 d-flex align-items-center justify-content-between">
                                            <input type="text" name="hour" value="{{ $receipt->receipt_date->format('h') }}" class="form-control">
                                            <div class="pL-10 pR-10">:</div>
                                            <input type="text" name="minute" value="{{ $receipt->receipt_date->format('i') }}" class="form-control">
                                        </div>
                                        <div class="col-4 d-flex align-items-center justify-content-between">
                                            <label class="mB-0">
                                                <input type="radio" name="merediem" value="AM" @if ($receipt->receipt_date->format('A') == 'AM') checked @endif >
                                                AM
                                            </label>

                                            <label class="mB-0">
                                                <input type="radio" name="merediem" value="PM" @if ($receipt->receipt_date->format('A') == 'PM') checked @endif>
                                                PM
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Payment method</label>
                                    <p><i>Unknown</i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection