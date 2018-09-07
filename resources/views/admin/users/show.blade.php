@extends('layouts.admin')

@section('content')
<div class="row gap-20 masonry pos-r">
  <div class="masonry-sizer col-md-6"></div>
  <div class="masonry-item col-md-12">
    <div class="bgc-white p-20 bd">
      <h6 class="c-grey-900">Update user state</h6>
      <div class="mT-30">
          <div class="form-row">
              <div class="">
                  @foreach ($user->documents->take(3) as $document)
                      <img src="{{$document->path}}" data-high-res-src="https://us-east-1.tchyn.io/snopes-production/uploads/2017/09/maya-the-bee.jpg"class="img-thumbnail preview-img gallery-items" alt="">
                  @endforeach
              </div>
          </div>

          <div class="form-row">
              <form class="mr-2" action="/admin/approve/{{$user->id}}" method="post">
                  @csrf
                  <button type="submit" class="btn btn-success">Approve</button>
              </form>

              <form class="" action="/admin/reject/{{$user->id}}" method="post">
                  @csrf
                  <button type="submit" class="btn btn-danger">Reject</button>
              </form>
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
