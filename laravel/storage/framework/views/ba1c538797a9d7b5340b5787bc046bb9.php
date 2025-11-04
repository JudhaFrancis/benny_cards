

<?php $__env->startSection('main-content'); ?>
<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
            <?php echo $__env->make('backend.layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Price Range List</h6>
        <a href="<?php echo e(route('price-range.create')); ?>" class="btn btn-primary btn-sm float-right" title="Add Price Range">
            <i class="fas fa-plus"></i> Add Price Range
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php if(count($priceRanges) > 0): ?>
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
                    <?php $__currentLoopData = $priceRanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $priceRange): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($priceRanges->firstItem() + $index); ?></td>
                        <td><?php echo e($priceRange->title); ?></td>
                        <td><?php echo e($priceRange->slug); ?></td>
                        <td><?php echo e($priceRange->min_price); ?></td>
                        <td><?php echo e($priceRange->max_price); ?></td>

                        <td>
    <?php if($priceRange->photo): ?>
        <!-- Thumbnail Image -->
        <img src="<?php echo e(asset($priceRange->photo)); ?>" 
             class="img-fluid preview-img"
             style="max-width:80px; cursor:pointer;" 
             alt="price range image"
             data-toggle="modal"
             data-target="#imagePreviewModal<?php echo e($priceRange->id); ?>">
    <?php else: ?>
        <img src="<?php echo e(asset('backend/img/thumbnail-default.jpg')); ?>" 
             class="img-fluid"
             style="max-width:80px" 
             alt="default image">
    <?php endif; ?>
</td>

<!-- Image Preview Modal -->
<div class="modal fade image-preview-modal" 
     id="imagePreviewModal<?php echo e($priceRange->id); ?>" 
     tabindex="-1"
     role="dialog" 
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content"
             style="background: transparent; border: none; box-shadow: none;">
             
            <div class="modal-body text-center p-0 position-relative">
                <!-- Close Button -->
                <button type="button" 
                        class="close text-white position-absolute"
                        data-dismiss="modal" 
                        aria-label="Close"
                        style="top:10px; right:20px; font-size:2rem; z-index:10;">
                    &times;
                </button>

                <!-- Full Image -->
                <img src="<?php echo e(asset($priceRange->photo)); ?>" 
                     class="img-fluid rounded shadow"
                     style="max-height: 80vh;">
            </div>

        </div>
    </div>
</div>

                        <td>
                            <?php if($priceRange->status == 'active'): ?>
                            <span class="badge badge-success"><?php echo e($priceRange->status); ?></span>
                            <?php else: ?>
                            <span class="badge badge-warning"><?php echo e($priceRange->status); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- View button -->
                            <button type="button" class="btn btn-info btn-sm float-left mr-1" data-toggle="modal"
                                data-target="#viewModal<?php echo e($priceRange->id); ?>"
                                style="height:30px; width:30px;border-radius:50%" title="View">
                                <i class="fas fa-eye"></i>
                            </button>

                            <!-- Edit -->
                            <a href="<?php echo e(route('price-range.edit', $priceRange->id)); ?>"
                                class="btn btn-primary btn-sm float-left mr-1"
                                style="height:30px; width:30px;border-radius:50%" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Delete -->
                            <form method="POST" action="<?php echo e(route('price-range.destroy', $priceRange->id)); ?>"
                                style="display:inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('delete'); ?>
                                <button class="btn btn-danger btn-sm dltBtn" data-id="<?php echo e($priceRange->id); ?>"
                                    style="height:30px; width:30px;border-radius:50%" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal<?php echo e($priceRange->id); ?>" tabindex="-1" role="dialog"
                            aria-labelledby="viewModalLabel<?php echo e($priceRange->id); ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Price Range Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <!-- <p><strong>ID:</strong> <?php echo e($priceRange->id); ?></p> -->
                                        <p><strong>Title:</strong> <?php echo e($priceRange->title); ?></p>
                                        <p><strong>Slug:</strong> <?php echo e($priceRange->slug); ?></p>
                                        <p><strong>Min Price:</strong> <?php echo e($priceRange->min_price); ?></p>
                                        <p><strong>Max Price:</strong> <?php echo e($priceRange->max_price); ?></p>
                                        <p><strong>Status:</strong>
                                            <?php if($priceRange->status == 'active'): ?>
                                            <span class="badge badge-success"><?php echo e($priceRange->status); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-warning"><?php echo e($priceRange->status); ?></span>
                                            <?php endif; ?>
                                        </p>
                                        <p><strong>Photo:</strong></p>
                                        <?php if($priceRange->photo): ?>
                                        <img src="<?php echo e(asset($priceRange->photo)); ?>" class="img-fluid mr-2 mb-2 preview-click"
                                            style="max-width:150px" alt="<?php echo e($priceRange->title); ?>">
                                        <?php else: ?>
                                        <img src="<?php echo e(asset('backend/img/thumbnail-default.jpg')); ?>" class="img-fluid"
                                            style="max-width:150px" alt="default">
                                        <?php endif; ?>
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <span style="float:right"><?php echo e($priceRanges->links()); ?></span>
            <?php else: ?>
            <h6 class="text-center">No Price Ranges found!!! Please create a Price Range</h6>
            <?php endif; ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
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

        $(document).on('click', '.preview-click', function() {
        var src = $(this).attr('src');
        var parentModal = $(this).closest('.modal');
        $('#imagePreviewModal').data('parentModal', parentModal);
        if (parentModal.length) {
            parentModal.modal('hide');
        }
        $('#previewImage').attr('src', src);
        $('#imagePreviewModal').modal('show');
    });

    $('#imagePreviewModal').on('hidden.bs.modal', function() {
        var parentModal = $(this).data('parentModal');
        if (parentModal && parentModal.length) {
            parentModal.modal('show');
            $(this).removeData('parentModal');
        }
    });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\benny_cards\laravel\resources\views/backend/price_range/index.blade.php ENDPATH**/ ?>