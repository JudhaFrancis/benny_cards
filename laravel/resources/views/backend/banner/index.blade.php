@extends('backend.layouts.master')
@section('title', 'BENNY CARDS || Banner Page')
@section('main-content')
<!-- DataTales Example -->
<div class="card my-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header">
        <h3 class="m-0 font-weight-bold text-primary">Banners List</h3>
        <a href="{{route('banner.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
            data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Banner</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($banners) > 0)
            <table class="table table-custom" id="banner-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $index => $banner)
                    <tr>
                        <td>{{ $banners->firstItem() + $index }}</td>
                        <td>{{ $banner->title }}</td>
                        <td>{{ $banner->slug }}</td>
                        <td>
                            @if($banner->photo)
                            <!-- Thumbnail -->
                            <img src="{{ asset($banner->photo) }}" class="img-fluid preview-img"
                                style="max-width:80px; cursor:pointer;" alt="{{ $banner->title }}" data-toggle="modal"
                                data-target="#imagePreviewModal{{$banner->id}}">
                            @else
                            <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid"
                                style="max-width:80px" alt="default">
                            @endif
                        </td>

                        <!-- Image Preview Modal -->
                        <div class="modal fade image-preview-modal" id="imagePreviewModal{{$banner->id}}" tabindex="-1"
                            role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content"
                                    style="background:transparent; border:none; box-shadow:none;">
                                    <div class="modal-body text-center p-0 position-relative">
                                        <button type="button" class="close text-white position-absolute"
                                            data-dismiss="modal" aria-label="Close"
                                            style="top:10px; right:20px; font-size:2rem; z-index:10;">
                                            &times;
                                        </button>
                                        <img src="{{ asset($banner->photo) }}" class="img-fluid rounded shadow"
                                            style="max-height:80vh;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <td>
                            @if($banner->status == 'active')
                            <span class="badge badge-success">{{$banner->status}}</span>
                            @else
                            <span class="badge badge-warning">{{$banner->status}}</span>
                            @endif
                        </td>
                        <td>
                            <!-- View button -->
                            <button type="button" class="btn btn-info btn-sm mr-1" data-toggle="modal"
                                data-target="#viewModal{{$banner->id}}"
                                style="height:30px; width:30px;border-radius:50%" title="View">
                                <i class="far fa-eye"></i>
                            </button>

                            <a href="{{route('banner.edit', $banner->id)}}"
                                class="btn btn-edit btn-sm mr-1"
                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                data-placement="bottom"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{route('banner.destroy', [$banner->id])}}" style="display:inline-block;">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$banner->id}}
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                    data-placement="bottom" title="Delete"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </td>
                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal{{$banner->id}}" tabindex="-1" role="dialog"
                            aria-labelledby="viewModalLabel{{$banner->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Banner Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>ID:</strong> {{ $banner->id }}</p>
                                        <p><strong>Title:</strong> {{ $banner->title }}</p>
                                        <p><strong>Slug:</strong> {{ $banner->slug }}</p>
                                        <p><strong>Status:</strong>
                                            @if($banner->status == 'active')
                                            <span class="badge badge-success">{{$banner->status}}</span>
                                            @else
                                            <span class="badge badge-warning">{{$banner->status}}</span>
                                            @endif
                                        </p>
                                        <p><strong>Photo:</strong></p>
                                        @if($banner->photo)
                                        <img src="{{($banner->photo) }}" class="img-fluid mr-2 mb-2 preview-click"
                                            alt="{{ $banner->title }}">
                                        @else
                                        <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid"
                                            alt="default">
                                        @endif
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- Delete Modal --}}
                        {{-- <div class="modal fade" id="delModal{{$user->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="#delModal{{$user->id}}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="#delModal{{$user->id}}Label">Delete user</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{ route('banners.destroy',$user->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger"
                                            style="margin:auto; text-align:center">Parmanent
                                            delete user</button>
                                    </form>
                                </div>
                            </div>
                        </div>
        </div> --}}
        </tr>
        @endforeach
        </tbody>
        </table>
        <span style="float:right">{{$banners->links()}}</span>
        @else
        <h6 class="text-center">No banners found!!! Please create banner</h6>
        @endif
    </div>
</div>
</div>

<div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background: transparent; border: none; box-shadow: none;">
            <div class="modal-body text-center p-0 position-relative">
                <button type="button" class="close text-white position-absolute" data-dismiss="modal" aria-label="Close"
                    style="top:10px; right:20px; font-size:2rem; z-index:10;">
                    &times;
                </button>
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
    /* Animation */
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
        var parentModal = $(this).closest('.modal'); // find if inside another modal

        // Hide the parent modal temporarily (like the "View" modal)
        if (parentModal.length) {
            parentModal.modal('hide');
            $('#imagePreviewModal').data('parentModal', parentModal);
        }

        // Show global preview modal
        $('#previewImage').attr('src', src);
        $('#imagePreviewModal').modal('show');
    });

    // When preview modal closes, reopen the parent modal if any
    $('#imagePreviewModal').on('hidden.bs.modal', function() {
        var parentModal = $(this).data('parentModal');
        if (parentModal) {
            parentModal.modal('show');
            $(this).removeData('parentModal');
        }
    });
})
</script>
@endpush