@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Review</h5>
    <div class="card-body">
        <form method="post" action="{{ route('review.store') }}">
            @csrf

            <!-- Product -->
            <div class="form-group">
                <label>Product <span class="text-danger">*</span></label>
                <select name="product_id" class="form-control">
                    <option value="">-- Select Product --</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Reviewer Name -->
            <div class="form-group">
                <label>Reviewer Name</label>
                <input type="text" name="reviewer_name" class="form-control" placeholder="Enter reviewer name">
            </div>

            <!-- Title -->
            <div class="form-group">
                <label>Review Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter review title">
            </div>

            <!-- Description -->
            <div class="form-group">
                <label>Description</label>
                <textarea id="summary" class="form-control" name="description"></textarea>
            </div>

            <!-- Image -->
            <div class="form-group">
                <label>Image</label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose
                        </a>
                    </span>
                    <input id="thumbnail" class="form-control" type="text" name="image">
                </div>
                <div id="holder" style="margin-top:15px;max-height:100px;"></div>
            </div>

            <!-- Rating -->
            <div class="form-group">
                <label>Rating</label>
                <select name="rating" class="form-control" required>
                    <option value="" disabled selected>Select Rating</option>
                    <option value="1"> ★</option>
                    <option value="2"> ★★</option>
                    <option value="3"> ★★★</option>
                    <option value="4"> ★★★★</option>
                    <option value="5"> ★★★★★</option>
                </select>

            </div>

            <button type="submit" class="btn btn-success">Submit</button>

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

$('#summary').summernote({
    placeholder: "Write review description...",
    tabsize: 2,
    height: 120,
    callbacks: {
        onChange: function(contents, $editable) {
            $('#summary').val(contents); // update textarea value
        }
    }
});
</script>
@endpush