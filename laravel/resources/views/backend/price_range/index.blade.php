@extends('backend.layouts.master')

@section('main-content')
<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Price Range List</h6>
        <a href="{{ route('price-range.create') }}" class="btn btn-primary btn-sm float-right" title="Add Price Range">
            <i class="fas fa-plus"></i> Add Price Range
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($priceRanges) > 0)
            <table class="table table-bordered" id="priceRange-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Min Price</th>
                        <th>Max Price</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($priceRanges as $index => $priceRange)
                    <tr>
                        <td>{{ $priceRanges->firstItem() + $index }}</td>
                        <td>{{ $priceRange->title }}</td>
                        <td>{{ $priceRange->slug }}</td>
                        <td>{{ $priceRange->min_price }}</td>
                        <td>{{ $priceRange->max_price }}</td>

                        <td>
                            @if($priceRange->photo)
                            <img src="{{($priceRange->photo) }}" class="img-fluid" style="max-width:80px"
                                alt="{{ $priceRange->photo }}">
                            @else
                            <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid"
                                style="max-width:80px" alt="avatar.png">
                            @endif
                        </td>
                        <td>
                            @if($priceRange->status == 'active')
                            <span class="badge badge-success">{{ $priceRange->status }}</span>
                            @else
                            <span class="badge badge-warning">{{ $priceRange->status }}</span>
                            @endif
                        </td>
                        <td>
                            <!-- View button -->
                            <button type="button" class="btn btn-info btn-sm float-left mr-1" data-toggle="modal"
                                data-target="#viewModal{{ $priceRange->id }}"
                                style="height:30px; width:30px;border-radius:50%" title="View">
                                <i class="fas fa-eye"></i>
                            </button>

                            <!-- Edit -->
                            <a href="{{ route('price-range.edit', $priceRange->id) }}"
                                class="btn btn-primary btn-sm float-left mr-1"
                                style="height:30px; width:30px;border-radius:50%" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Delete -->
                            <form method="POST" action="{{ route('price-range.destroy', $priceRange->id) }}"
                                style="display:inline-block;">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id="{{ $priceRange->id }}"
                                    style="height:30px; width:30px;border-radius:50%" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal{{ $priceRange->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="viewModalLabel{{ $priceRange->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Price Range Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <p><strong>ID:</strong> {{ $priceRange->id }}</p>
                                        <p><strong>Title:</strong> {{ $priceRange->title }}</p>
                                        <p><strong>Slug:</strong> {{ $priceRange->slug }}</p>
                                        <p><strong>Min Price:</strong> {{ $priceRange->min_price }}</p>
                                        <p><strong>Max Price:</strong> {{ $priceRange->max_price }}</p>
                                        <p><strong>Status:</strong>
                                            @if($priceRange->status == 'active')
                                            <span class="badge badge-success">{{ $priceRange->status }}</span>
                                            @else
                                            <span class="badge badge-warning">{{ $priceRange->status }}</span>
                                            @endif
                                        </p>
                                        <p><strong>Photo:</strong></p>
                                        @if($priceRange->photo)
                                        <img src="{{ asset($priceRange->photo) }}" class="img-fluid"
                                            style="max-width:150px" alt="{{ $priceRange->title }}">
                                        @else
                                        <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid"
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
                        <!-- End Modal -->

                    </tr>
                    @endforeach
                </tbody>
            </table>
            <span style="float:right">{{ $priceRanges->links() }}</span>
            @else
            <h6 class="text-center">No Price Ranges found!!! Please create a Price Range</h6>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    // Sweet alert delete
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.dltBtn').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                } else {
                    swal("Your data is safe!");
                }
            });
        });
    });
</script>
@endpush