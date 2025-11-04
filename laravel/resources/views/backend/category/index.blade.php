@extends('backend.layouts.master')

@section('main-content')
<!-- DataTales Example -->
<div class="card my-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header">
        <h3 class="m-0 font-weight-bold text-primary float-left">Category Lists</h3>
        <a href="{{route('category.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
            data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Category</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($categories) > 0)
            <table class="table table-custom" id="banner-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Is Parent</th>
                        <th>Parent Category</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($categories as $category)
                    @php
                    @endphp
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->title}}</td>
                        <td>{{$category->slug}}</td>
                        <td>{{(($category->is_parent == 1) ? 'Yes' : 'No')}}</td>
                        <td>
                            {{$category->parent_info->title ?? ''}}
                        </td>
                        <td>
                            @if($category->photo)
                            <!-- Thumbnail Image -->
                            <img src="{{ asset($category->photo) }}" class="img-fluid preview-img"
                                style="max-width:80px; cursor:pointer;" alt="category image" data-toggle="modal"
                                data-target="#imagePreviewModal{{$category->id}}">
                            @else
                            <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid"
                                style="max-width:80px" alt="default image">
                            @endif
                        </td>

                        <!-- Image Preview Modal -->
                        <div class="modal fade image-preview-modal" id="imagePreviewModal{{$category->id}}"
                            tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content"
                                    style="background: transparent; border: none; box-shadow: none;">

                                    <div class="modal-body text-center p-0 position-relative">
                                        <!-- Close Button -->
                                        <button type="button" class="close text-white position-absolute"
                                            data-dismiss="modal" aria-label="Close"
                                            style="top:10px; right:20px; font-size:2rem; z-index:10;">
                                            &times;
                                        </button>

                                        <!-- Full Image -->
                                        <img src="{{ asset($category->photo) }}" class="img-fluid rounded shadow"
                                            style="max-height: 80vh;">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <td>
                            @if($category->status == 'active')
                            <span class="badge badge-success">{{$category->status}}</span>
                            @else
                            <span class="badge badge-warning">{{$category->status}}</span>
                            @endif
                        </td>
                        <td>
                            <!-- View button -->
                            <button type="button" class="btn btn-info btn-sm mr-1" data-toggle="modal"
                                data-target="#viewModal{{$category->id}}"
                                style="height:30px; width:30px;border-radius:50%" title="View">
                                <i class="fas fa-eye"></i>
                            </button>

                            <a href="{{route('category.edit', $category->id)}}"
                                class="btn btn-primary btn-sm mr-1"
                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                data-placement="bottom"><i class="fas fa-edit"></i>
                            </a>

                            <form method="POST" action="{{route('category.destroy', [$category->id])}}" style="display:inline-block;">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$category->id}}
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                    data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal{{$category->id}}" tabindex="-1" role="dialog"
                            aria-labelledby="viewModalLabel{{$category->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Category Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <p><strong>ID:</strong> {{ $category->id }}</p>
                                        <p><strong>Title:</strong> {{ $category->title }}</p>
                                        <p><strong>Slug:</strong> {{ $category->slug }}</p>
                                        <p><strong>Is Parent:</strong> {{ $category->is_parent == 1 ? 'Yes' : 'No' }}
                                        </p>
                                        <p><strong>Parent Category:</strong>
                                            {{ $category->parent_info->title ?? 'N/A' }}</p>
                                        <p><strong>Status:</strong>
                                            @if($category->status == 'active')
                                            <span class="badge badge-success">{{$category->status}}</span>
                                            @else
                                            <span class="badge badge-warning">{{$category->status}}</span>
                                            @endif
                                        </p>
                                        <p><strong>Photo:</strong></p>
                                        @if($category->photo)
                                        <img src="{{asset($category->photo) }}" class="img-fluid mr-2 mb-2 preview-click"
                                            style="max-width:150px" alt="{{ $category->title }}">
                                        @else
                                        <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class=""
                                            style="max-width:150px" alt="default">
                                        @endif
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </tr>

                    @endforeach
                </tbody>
            </table>
            <span style="float:right">{{$categories->links()}}</span>
            @else
            <h6 class="text-center">No Categories found!!! Please create Category</h6>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background: transparent; border: none; box-shadow: none;">
      <div class="modal-body text-center p-0 position-relative">
        <!-- Close Button -->
        <button type="button" class="close text-white position-absolute" data-dismiss="modal" aria-label="Close"
          style="top:10px; right:20px; font-size:2rem; z-index:10;">
          &times;
        </button>
        <!-- Full Image -->
        <img id="previewImage" src="" class="img-fluid rounded shadow" style="max-height: 80vh;">
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
div.dataTables_wrapper div.dataTables_paginate {
    display: none;
}

.zoom {
    transition: transform .2s;
}

.zoom:hover {
    transform: scale(5);
}

.image-preview-modal .modal-dialog {
    max-width: 80%;
}

.image-preview-modal .modal-content {
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent;
    border: none;
    box-shadow: none;
}

.modal-backdrop.show {
    opacity: 0.9;
}
</style>
@endpush

@push('scripts')

<!-- Page level plugins -->
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
$('#banner-dataTable').DataTable({
    "columnDefs": [{
        "orderable": false,
        "targets": [3, 4, 5]
    }]
});

// Sweet alert

function deleteData(id) {

}
</script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.dltBtn').click(function(e) {
        var form = $(this).closest('form');
        var dataID = $(this).data('id');
        // alert(dataID);
        e.preventDefault();
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                } else {
                    swal("Your data is safe!");
                }
            });
    })
    $(document).on('click', '.preview-click', function() {
        var src = $(this).attr('src');
        var parentModal = $(this).closest('.modal'); // find current open modal

        //Temporarily store which modal was open
        $('#imagePreviewModal').data('parentModal', parentModal);

        // Hide current modal (if open)
        if (parentModal.length) {
            parentModal.modal('hide');
        }

        // Show image preview
        $('#previewImage').attr('src', src);
        $('#imagePreviewModal').modal('show');
    });

    //  Use one global event
    $('#imagePreviewModal').on('hidden.bs.modal', function() {
        var parentModal = $(this).data('parentModal');
        if (parentModal && parentModal.length) {
            parentModal.modal('show');

            $(this).removeData('parentModal');
        }
    });

})
</script>
@endpush