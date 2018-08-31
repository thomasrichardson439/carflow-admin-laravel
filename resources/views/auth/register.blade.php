@extends('layouts.admin')

@section('content')
    <div class="peers ai-s fxw-nw h-100vh">
      <div class="peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv" style='background-image: url("/images/bg.jpg")'>
        <div class="pos-a centerXY">
          <div class="bgc-white bdrs-50p pos-r" style='width: 120px; height: 120px;'>
            <img class="pos-a centerXY" src="/images/logo.png" alt="">
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style='min-width: 320px;'>
        <h4 class="fw-300 c-grey-900 mB-40">Register</h4>
        <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
          @csrf
          <div class="form-group">
            <label class="text-normal text-dark">Username</label>
            <input name="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" Placeholder='John Doe'>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <label class="text-normal text-dark">Email Address</label>
            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" Placeholder='name@email.com'>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <label class="text-normal text-dark">Password</label>
            <input name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password">

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <label class="text-normal text-dark">Confirm Password</label>
            <input name="password_confirmation" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password">
          </div>
          <div class="form-group">
            <button class="btn btn-primary">Register</button>
          </div>
        </form>
      </div>
    </div>
@endsection
