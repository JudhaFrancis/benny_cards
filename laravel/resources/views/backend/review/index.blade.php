@extends('backend.layouts.master')

@section('main-content')
<div class="card my-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>

    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="m-0 font-weight-bold text-primary float-left">Review Lists</h3>
        <a href="{{ route('review.create') }}" class="btn btn-primary btn-sm float-right">
            <i class="fas fa-plus"></i> Add Review
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            @if(count($reviews) > 0)
            <table class="table table-custom" id="review-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Reviewer Name</th>
                        <th>Product Title</th>
                        <th>Title</th>
                        <th>Rating</th>
                        <th>Date</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ $review->reviewer_name ?? 'N/A' }}</td>
                        <td>{{ $review->product->title ?? 'N/A' }}</td>
                        <td>{{ $review->title ?? '-' }}</td>
                        <td>
                            <ul style="list-style:none; padding:0; margin:0; display:flex;">
                                @for($i=1; $i<=5; $i++) @if($review->rating >= $i)
                                    <li style="color:#ec1176; margin-right:3px;">
                                        <i class="fa fa-star"></i>
                                    </li>
                                    @else
                                    <li style="color:#ec1176; margin-right:3px;">
                                        <i class="far fa-star"></i>
                                    </li>
                                    @endif
                                    @endfor
                            </ul>
                        </td>

                        <td>{{ $review->created_at->format('M d, Y g:i a') }}</td>
                        <td>
                            @if($review->image)
                            <img src="{{ $review->image }}" width="50" height="50"
                                class="img-fluid rounded preview-click" data-src="{{ $review->image }}">
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            <!-- View button -->
                            <button type="button" class="btn btn-info btn-sm mb-1" data-toggle="modal"
                                data-target="#viewModal{{$review->id}}"
                                style="width:30px; height:30px; border-radius:50%" title="View">
                                <i class="fas fa-eye"></i>
                            </button>

                            <a href="{{ route('review.edit', $review->id) }}" class="btn btn-primary btn-sm mb-1"
                                style="width:30px; height:30px;border-radius:50%" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form method="POST" action="{{ route('review.destroy', $review->id) }}"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm dltBtn mb-1"
                                    style="width:30px; height:30px;border-radius:50%" data-id="{{ $review->id }}"
                                    title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- View Modal -->
                    <div class="modal fade" id="viewModal{{$review->id}}" tabindex="-1" role="dialog"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Review Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Reviewer Name:</strong> {{ $review->reviewer_name ?? 'N/A' }}</p>
                                    <p><strong>Product:</strong> {{ $review->product->title ?? 'N/A' }}</p>
                                    <p><strong>Title:</strong> {{ $review->title ?? '-' }}</p>
                                    <p><strong>Description:</strong> {!! $review->description !!}</p>
                                    <p><strong>Rating:</strong>
                                        @for($i = 1; $i <= 5; $i++) @if($review->rating >= $i)
                                            <i class="fa fa-star" style="color:#ec1176;"></i>
                                            @else
                                            <i class="far fa-star" style="color:#ec1176;"></i>
                                            @endif
                                            @endfor
                                    </p>

                                    <p><strong>Date:</strong> {{ $review->created_at->format('M d, Y g:i a') }}</p>
                                    @if($review->image)
                                    <p><strong>Image:</strong></p>
                                    <img src="{{ $review->image }}" class="img-fluid rounded" style="max-width:150px;">
                                    @endif
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>

            <div class="mt-3 d-flex justify-content-end">{{ $reviews->links() }}</div>
            @else
            <h6 class="text-center">No reviews found!!!</h6>
            @endif

        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
div.dataTables_wrapper div.dataTables_paginate {
    display: none;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$('#review-dataTable').DataTable({
    "columnDefs": [{
        "orderable": false,
        "targets": [6, 7]
    }]
});

$(document).ready(function() {
    // Delete confirmation
    $('.dltBtn').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you cannot recover this review!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });

    // Global image preview
    $(document).on('click', '.preview-click', function() {
        var src = $(this).data('src');
        $('#previewImage').attr('src', src);
        $('#imagePreviewModal').modal('show');
    });
});
</script>
@endpush