@extends('layouts.admin')

@section('content')
<div class="row gap-20 masonry pos-r">
  <div class="masonry-sizer col-md-6"></div>
  <div class="masonry-item col-md-12">
    <div class="bgc-white p-20 bd">
      <div class="mT-30">
        <div class="form-row">
          <div class="">
            <h4 class="c-grey-900">Driving License</h4>
            <div class="form-row">
                <div class="">
                  @if($user->drivingLicense)
                      <img src="{{$user->drivingLicense->front}}" data-high-res-src="{{$user->drivingLicense->front}}" class="img-thumbnail preview-img gallery-items" alt="">
                      <img src="{{$user->drivingLicense->back}}" data-high-res-src="{{$user->drivingLicense->back}}" class="img-thumbnail preview-img gallery-items" alt="">
                  @endif
                </div>
            </div>
          </div>
          <div class="ml-5">
            <h4 class="c-grey-900">TLC License</h4>
            <div class="form-row">
                <div class="">
                  @if($user->tlcLicense)
                    @if($user->drivingLicense)
                        <img src="{{$user->tlcLicense->front}}" data-high-res-src="{{$user->tlcLicense->front}}" class="img-thumbnail preview-img gallery-items" alt="">
                        <img src="{{$user->tlcLicense->back}}" data-high-res-src="{{$user->tlcLicense->back}}" class="img-thumbnail preview-img gallery-items" alt="">
                    @endif
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
          @if($user->status === 'pending')
            <a href="/admin/users" class="btn btn-primary mr-2">Back</a>
            <form class="mr-2" action="/admin/approve/{{$user->id}}" method="post">
                @csrf
                <button type="submit" class="btn btn-success">Block</button>
            </form>
            <form class="mr-2" action="/admin/reject/{{$user->id}}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger">Reject</button>
            </form>
          @endif
          @if($user->status === 'approved')
            <a href="/admin/users" class="btn btn-primary mr-2">Back</a>
            <div class="">
              <form class="" action="/admin/reject/{{$user->id}}" method="post">
                  @csrf
                  <button type="submit" class="btn btn-danger">Unapprove</button>
              </form>
            </div>

          @endif
          @if($user->status === 'rejected')
            <a href="/admin/users" class="btn btn-primary mr-2">Back</a>

            <div class="">
              <form class="mr-2" action="/admin/approve/{{$user->id}}" method="post">
                  @csrf
                  <button type="submit" class="btn btn-success">Approve</button>
              </form>
            </div>

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
