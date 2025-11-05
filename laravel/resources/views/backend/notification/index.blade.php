@extends('backend.layouts.master')
@section('title','BENNY CARDS || All Notifications')
@section('main-content')
<div class="card">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <h5 class="card-header">Notifications</h5>
    <div class="card-body">
        @php
        use App\Models\Notification;
        $notifications = Notification::orderByDesc('created_at')->get();
        @endphp

        @if($notifications && $notifications->count() > 0)

        <table class="table  table-hover admin-table" id="notification-dataTable">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Message</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Message Type</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Updated On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $notification)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                        title="{{ $notification->message }}">
                        {{ $notification->message ?? 'No message' }}
                    </td>
                    <td>{{ $notification->sender_mobile_no ?? '-' }}</td>
                    <td>{{ $notification->recipient_mobile_no ?? '-' }}</td>
                    <td>
                        @if(strtolower($notification->message_type) == 'whatsapp')
                        <span class="badge badge-success">WhatsApp</span>
                        @elseif(strtolower($notification->message_type) == 'sms')
                        <span class="badge badge-primary">SMS</span>
                        @else
                        <span class="badge badge-secondary">N/A</span>
                        @endif
                    </td>
                    <td>
                        @if($notification->status == 'failed')
                        <span class="badge badge-danger">Failed</span>
                        @elseif($notification->status == 'sent')
                        <span class="badge badge-success">Sent</span>
                        @elseif($notification->status == 'not_sent')
                        <span class="badge badge-warning text-dark">Not Sent</span>
                        @else
                        <span class="badge badge-secondary">Unknown</span>
                        @endif
                    </td>
                    <td>{{ $notification->created_at ? $notification->created_at->format('d-M-Y') : '-' }}</td>
                    <td>{{ $notification->updated_at ? $notification->updated_at->format('d-M-Y') : '-' }}</td>

                    <td>
                        <!-- 👁️ View Button -->
                        <button class="btn btn-primary btn-sm float-left mr-1"
                            style="height:30px; width:30px; border-radius:50%" data-toggle="modal"
                            data-target="#viewNotification{{ $notification->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </button>

                        <!-- Resend Button -->
                        <button type="button" class="btn btn-danger btn-sm resendBtn" data-id="{{ $notification->id }}"
                            style="height:30px; width:30px; border-radius:50%" title="Resend">
                            <i class="fas fa-paper-plane"></i>
                        </button>

                    </td>
                </tr>

                <!--  Modal for Viewing Details -->
                <div class="modal fade" id="viewNotification{{ $notification->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="viewNotificationLabel{{ $notification->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="viewNotificationLabel{{ $notification->id }}">
                                    Message Log Info
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-2">
                                    <div class="col-md-6"><strong>From :</strong>
                                        {{ $notification->sender_mobile_no ?? '-' }}</div>
                                    <div class="col-md-6"><strong>To :</strong>
                                        {{ $notification->recipient_mobile_no ?? '-' }}</div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <strong>Message Type :</strong>
                                        @if(strtolower($notification->message_type) == 'whatsapp')
                                        <span class="badge badge-success">WhatsApp</span>
                                        @elseif(strtolower($notification->message_type) == 'sms')
                                        <span class="badge badge-primary">SMS</span>
                                        @else
                                        <span class="badge badge-secondary">N/A</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Status :</strong>
                                        @if($notification->status == 'failed')
                                        <span class="badge badge-danger">Failed</span>
                                        @elseif($notification->status == 'sent')
                                        <span class="badge badge-success">Sent</span>
                                        @elseif($notification->status == 'not_sent')
                                        <span class="badge badge-warning text-dark">Not Sent</span>
                                        @else
                                        <span class="badge badge-secondary">Unknown</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <strong>Message :</strong>
                                        <div class="border p-2 rounded mt-1" style="background:#f8f9fa">
                                            {!! nl2br(e($notification->message ?? 'No message available')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6"><strong>Created On :</strong>
                                        {{ $notification->created_at ? $notification->created_at->format('d-M-Y') : '-' }}
                                    </div>
                                    <div class="col-md-6"><strong>Updated On :</strong>
                                        {{ $notification->updated_at ? $notification->updated_at->format('d-M-Y') : '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        @else
        <h2>Notifications Empty!</h2>
        @endif
    </div>
</div>
@endsection
@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

@endpush
@push('scripts')
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
$('#notification-dataTable').DataTable({
    "columnDefs": [{
        "orderable": false,
        "targets": [3]
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
})
</script>
<script>
$(document).ready(function() {
    $('.resendBtn').on('click', function() {
        let id = $(this).data('id');
        let button = $(this);

        // Disable the button and show spinner
        button.prop('disabled', true);
        button.html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: `/api/whatsappResent/${id}`,
            type: 'POST',
            success: function(response) {
                // Check backend status
                if (response.result && response.result.status === true) {
                    swal({
                        title: "Success!",
                        text: response.message || "WhatsApp message sent successfully.",
                        icon: "success",
                        timer: 1500,
                        buttons: false,
                    });
                } else {
                    swal({
                        title: "Failed!",
                        text: response.message || "WhatsApp message failed to send.",
                        icon: "error",
                        timer: 2000,
                        buttons: false,
                    });
                }
            },
            error: function(xhr) {
                swal({
                    title: "Error!",
                    text: xhr.responseJSON?.message || "Something went wrong. Try again later.",
                    icon: "error",
                    timer: 2000,
                    buttons: false,
                });
            },
            complete: function() {
                button.prop('disabled', false);
                button.html('<i class="fas fa-paper-plane"></i>');
                setTimeout(() => location.reload(), 2500);
            }
        });
    });
});

</script>

@endpush