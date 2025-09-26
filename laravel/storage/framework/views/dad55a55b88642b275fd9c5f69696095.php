
<?php $__env->startSection('title', 'BENNY CARDS || Banner Page'); ?>
<?php $__env->startSection('main-content'); ?>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="row">
    <div class="col-md-12">
      <?php echo $__env->make('backend.layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    </div>
    <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary float-left">Banners List</h6>
    <a href="<?php echo e(route('banner.create')); ?>" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
      data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Banner</a>
    </div>
    <div class="card-body">
    <div class="table-responsive">
      <?php if(count($banners) > 0): ?>
      <table class="table table-bordered" id="banner-d    ataTable" width="100%" cellspacing="0">
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
      <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($banners->firstItem() + $index); ?></td>
        <td><?php echo e($banner->title); ?></td>
        <td><?php echo e($banner->slug); ?></td>
      <td>
      <?php if($banner->photo): ?>
      <img src="<?php echo e($banner->photo); ?>" class="img-fluid zoom" style="max-width:80px" alt="<?php echo e($banner->photo); ?>">
      <?php else: ?>
      <img src="<?php echo e(asset('backend/img/thumbnail-default.jpg')); ?>" class="img-fluid zoom" style="max-width:100%"
      alt="avatar.png">
      <?php endif; ?>
      </td>
      <td>
      <?php if($banner->status == 'active'): ?>
      <span class="badge badge-success"><?php echo e($banner->status); ?></span>
      <?php else: ?>
      <span class="badge badge-warning"><?php echo e($banner->status); ?></span>
      <?php endif; ?>
      </td>
      <td>
      <!-- View button -->
      <button type="button" class="btn btn-info btn-sm float-left mr-1" data-toggle="modal"
      data-target="#viewModal<?php echo e($banner->id); ?>" style="height:30px; width:30px;border-radius:50%" title="View">
      <i class="fas fa-eye"></i>
      </button>

      <a href="<?php echo e(route('banner.edit', $banner->id)); ?>" class="btn btn-primary btn-sm float-left mr-1"
      style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
      data-placement="bottom"><i class="fas fa-edit"></i></a>
      <form method="POST" action="<?php echo e(route('banner.destroy', [$banner->id])); ?>">
      <?php echo csrf_field(); ?>
      <?php echo method_field('delete'); ?>
      <button class="btn btn-danger btn-sm dltBtn" data-id=<?php echo e($banner->id); ?>

      style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom"
      title="Delete"><i class="fas fa-trash-alt"></i></button>
      </form>
      </td>
      <!-- View Modal -->
      <div class="modal fade" id="viewModal<?php echo e($banner->id); ?>" tabindex="-1" role="dialog"
      aria-labelledby="viewModalLabel<?php echo e($banner->id); ?>" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Banner Details</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <p><strong>ID:</strong> <?php echo e($banner->id); ?></p>
      <p><strong>Title:</strong> <?php echo e($banner->title); ?></p>
      <p><strong>Slug:</strong> <?php echo e($banner->slug); ?></p>
      <p><strong>Status:</strong>
        <?php if($banner->status == 'active'): ?>
      <span class="badge badge-success"><?php echo e($banner->status); ?></span>
      <?php else: ?>
      <span class="badge badge-warning"><?php echo e($banner->status); ?></span>
      <?php endif; ?>
      </p>
      <p><strong>Photo:</strong></p>
      <?php if($banner->photo): ?>
      <img src="<?php echo e(($banner->photo)); ?>" class="img-fluid" alt="<?php echo e($banner->title); ?>">
      <?php else: ?>
      <img src="<?php echo e(asset('backend/img/thumbnail-default.jpg')); ?>" class="img-fluid" alt="default">
      <?php endif; ?>
      </div>
      <div class="modal-footer d-flex justify-content-center">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

      </div>
      </div>
      </div>
      
      
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
      </table>
      <span style="float:right"><?php echo e($banners->links()); ?></span>
    <?php else: ?>
      <h6 class="text-center">No banners found!!! Please create banner</h6>
    <?php endif; ?>
    </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
  <link href="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
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
    transform: scale(3.2);
    }
  </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

  <!-- Page level plugins -->
  <script src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?php echo e(asset('backend/js/demo/datatables-demo.js')); ?>"></script>
  <script>

    $('#banner-dataTable').DataTable({
    "columnDefs": [
      {
      "orderable": false,
      "targets": [3, 4, 5]
      }
    ]
    });

    // Sweet alert

    function deleteData(id) {

    }
  </script>
  <script>
    $(document).ready(function () {
    $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('.dltBtn').click(function (e) {
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/backend/banner/index.blade.php ENDPATH**/ ?>