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
        <h3 class="m-0 font-weight-bold text-primary float-left">Invitation Cards Lists</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($cards) > 0)
            <table class="table table-custom" id="card-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Brand</th>
                        <th>Stock</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($cards as $index => $card)
                    @php
                    $sub_cat_info = DB::table('categories')->select('title')->where('id',
                    $card->child_cat_id)->get();
                    // dd($sub_cat_info);
                    $brands = DB::table('brands')->select('title')->where('id', $card->brand_id)->get();
                    @endphp
                    <tr>
                        <td>{{ $cards->firstItem() + $index }}</td>
                        <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" data-toggle="tooltip" data-placement="top" title="{{ $card->title }}">
                            {{ Str::limit($card->title, 30) }}
                        </td>
                        <td>{{$card->cat_info['title']}}
                            <sub>
                                {{$card->sub_cat_info->title ?? ''}}
                            </sub>
                        </td>
                        <td>{{$card->price}}</td>
                        <td> {{$card->discount}}% OFF</td>
                        <td>{{ ucfirst($card->brand?->title ?? 'N/A') }}</td>

                        <td>
                            @if($card->stock > 0)
                            <span class="badge badge-primary">{{$card->stock}}</span>
                            @else
                            <span class="badge badge-danger">{{$card->stock}}</span>
                            @endif
                        </td>
                        <td>
                            @if($card->photo)
                            @php $photo = explode(',', $card->photo); @endphp
                            <img src="{{ asset($photo[0]) }}" class="img-fluid preview-img"
                                style="max-width:80px; cursor:pointer;" alt="card image" data-toggle="modal"
                                data-target="#imagePreviewModal{{$card->id}}">
                            @else
                            <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid"
                                style="max-width:80px" alt="avatar.png">
                            @endif
                        </td>

                        <div class="modal fade image-preview-modal" id="imagePreviewModal{{$card->id}}" tabindex="-1"
                            role="dialog" aria-hidden="true">
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

                                        <!-- Image -->
                                        <img src="{{ asset($photo[0]) }}" class="img-fluid rounded shadow"
                                            style="max-height: 80vh;">
                                    </div>

                                </div>
                            </div>
                        </div>


                        <td>
                            @if($card->status == 'active')
                            <span class="badge badge-success">{{$card->status}}</span>
                            @else
                            <span class="badge badge-warning">{{$card->status}}</span>
                            @endif
                        </td>
                        <td>
                            <!-- View Button -->
                            <button type="button" class="btn btn-info btn-sm mr-1" data-toggle="modal"
                                data-target="#viewModal{{$card->id}}"
                                style="height:30px; width:30px;border-radius:50%" title="View">
                                <i class="fas fa-eye"></i>
                            </button>

                            <a href="{{route('invitation_cards.edit', $card->id)}}"
                                class="btn btn-edit btn-sm mr-1"
                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                data-placement="bottom"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{route('invitation_cards.destroy', [$card->id])}}" style="display:inline-block;">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$card->id}}
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                    data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal{{$card->id}}" tabindex="-1" role="dialog"
                            aria-labelledby="viewModalLabel{{$card->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">card Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>ID:</strong> {{$card->id}}</p>
                                                <p><strong>Title:</strong> {{$card->title}}</p>
                                                <p><strong>Category:</strong> {{$card->cat_info['title']}}
                                                    <sub>{{$card->sub_cat_info->title ?? ''}}</sub>
                                                </p>
                                                <p><strong>Brand:</strong> {{ucfirst($card->brand->title ?? 'N/A')}}
                                                </p>
                                                <p><strong>Condition:</strong> {{$card->condition}}</p>
                                                <p><strong>Size:</strong> {{$card->size}}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Price:</strong> Rs. {{$card->price}} /-</p>
                                                <p><strong>Discount:</strong> {{$card->discount}}% OFF</p>
                                                <p><strong>Featured:</strong>
                                                    {{($card->is_featured == 1) ? 'Yes' : 'No'}}
                                                </p>
                                                <p><strong>Stock:</strong>
                                                    @if($card->stock > 0)
                                                    <span class="badge badge-primary">{{$card->stock}}</span>
                                                    @else
                                                    <span class="badge badge-danger">{{$card->stock}}</span>
                                                    @endif
                                                </p>
                                                <p><strong>Status:</strong>
                                                    @if($card->status == 'active')
                                                    <span class="badge badge-success">{{$card->status}}</span>
                                                    @else
                                                    <span class="badge badge-warning">{{$card->status}}</span>
                                                    @endif
                                                </p>
                                                <p><strong>Photo:</strong></p>
                                                @if($card->photo)
                                                @php $photos = explode(',', $card->photo); @endphp
                                                @foreach($photos as $img)
                                                <img src="{{ asset($img) }}" class="img-fluid mr-2 mb-2 preview-click"
                                                    style="max-width:100px; cursor:pointer;" alt="card image">
                                                @endforeach
                                                @else
                                                <img src="{{ asset('backend/img/thumbnail-default.jpg') }}"
                                                    class="img-fluid" style="max-width:100px" alt="avatar.png">
                                                @endif

                                            </div>
                                        </div>
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
            <span style="float:right">{{$cards->links()}}</span>
            @else
            <h6 class="text-center">No Invitation cards found!!! Please create Invitation card</h6>
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

                <!-- Image -->
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
    $(document).ready(function() {
        // Initialize DataTable first
        var table = $('#card-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [3, 4, 5]
            }],
            "language": {
                "search": "", // remove "Search:" label
                "searchPlaceholder": "Search cards..." // optional placeholder text
            }
        });

        // Add button next to search input
        var addButton = `<a href="{{route('invitation_cards.create')}}" class="btn btn-primary btn-sm ml-2" 
                        data-toggle="tooltip" data-placement="bottom" title="Add card">
                        <i class="fas fa-plus"></i> Add card
                     </a>`;

        // Append the button inside the filter container, aligned with input
        $('#card-dataTable_filter').append(addButton);
    });
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

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endpush