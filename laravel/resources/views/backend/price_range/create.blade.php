@extends('backend.layouts.master')

@section('main-content')

  <div class="card">
    <h5 class="card-header">Add Price Range</h5>
    <div class="card-body">
      <form method="post" action="{{route('price-range.store')}}">
        {{csrf_field()}}

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{old('title')}}"
            class="form-control">
          @error('title')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="min_price" class="col-form-label">Minimum Price</label>
          <input id="min_price" type="number" name="min_price" placeholder="Enter minimum price"
            value="{{old('min_price')}}" class="form-control">
          @error('min_price')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="max_price" class="col-form-label">Maximum Price</label>
          <input id="max_price" type="number" name="max_price" placeholder="Enter maximum price"
            value="{{old('max_price')}}" class="form-control">
          @error('max_price')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo</label>
          <div class="input-group">
            <span class="input-group-btn">
              <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                <i class="fa fa-picture-o"></i> Choose
              </a>
            </span>
            <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
          </div>
          <div id="holder" style="margin-top:15px;max-height:100px;"></div>

          @error('photo')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{old('status') == 'active' ? 'selected' : ''}}>Active</option>
            <option value="inactive" {{old('status') == 'inactive' ? 'selected' : ''}}>Inactive</option>
          </select>
          @error('status')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
          <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
  </div>

@endsection

@push('styles')
  <link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
  <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
  <script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
  <script>
    $('#lfm').filemanager('image');
  </script>
@endpush