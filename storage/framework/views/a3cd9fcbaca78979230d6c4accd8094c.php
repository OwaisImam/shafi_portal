

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Pre_Production_Plan'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('build/libs/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')); ?>" rel="stylesheet"
        type="text/css">
    <link href="<?php echo e(URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(URL::asset('build/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css')); ?>" rel="stylesheet"
        type="text/css">
    <link href="<?php echo e(URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')); ?>" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('build/libs/toastr/build/toastr.min.css')); ?>">
    <link href="<?php echo e(URL::asset('build/libs/dragula/dragula.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Orders
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Order Details
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5>Order Details</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-responsive table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Order Code</th>
                                        <td><?php echo e($order->code); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Job ID</th>
                                <th>Client Name</th>
                                <th>State</th>
                                <th>Shipping Address</th>
                                <th>PO Receive Date</th>
                                <th>Delivery Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo e($order->job->number); ?></td>
                                <td><?php echo e($order->client->name); ?></td>
                                <td><?php echo e($order->client->city->state->name); ?></td>
                                <td><?php echo e($order->client->address); ?></td>
                                <td><?php echo e($order->po_receive_date); ?></td>
                                <td><?php echo e($order->delivery_date); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Fabric Construction</th>
                                <th>Total Order Quantity</th>
                                <th>Total Article Style</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo e($order?->fabric_construction?->name); ?></td>
                                <td><?php echo e($order->order_quantity . ' ' . $order->order_items->first()->unit); ?>

                                </td>
                                <td><?php echo e($order->article_style_count); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4>Order Items</h4>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Article Style No</th>
                                    <th>Article Style</th>
                                    <th>Description</th>
                                    <th>Sizes</th>
                                    <th>Color</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>GSM</th>
                                    <th>Range</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->order_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $sizes = json_decode($item->sizes);
                                    ?>
                                    <tr>
                                        <td><?php echo e($item->article_style_no); ?></td>
                                        <td><?php echo e($item->article->name); ?></td>
                                        <td><?php echo e($item->description); ?></td>
                                        <td>
                                            <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($size); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td>
                                            <div class="rounded overflow-hidden">
                                                <div class="p-1" style="background-color: <?php echo e($item->color); ?>">
                                                    <h5 class="my-1 text-white font-size-12 text-center">
                                                        <?php echo e($item->color); ?></h5>
                                                </div>
                                            </div>

                                        </td>
                                        <td><?php echo e($item->qty); ?></td>
                                        <td><?php echo e($item->unit); ?></td>
                                        <td><?php echo e($item->gsm); ?></td>
                                        <td><?php echo e($item?->range?->name); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/inputmask/inputmask.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/inputmask/jquery.inputmask.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/js/pages/form-mask.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/parsleyjs/parsley.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/form-validation.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/select2/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/js/pages/form-advanced.init.js')); ?>"></script>
    <!-- form advanced init -->
    <script src="<?php echo e(URL::asset('build/libs/toastr/build/toastr.min.js')); ?>"></script>
    <!-- toastr init -->
    <script src="<?php echo e(URL::asset('build/js/pages/toastr.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/dragula/dragula.min.js')); ?>"></script>

    <!-- jquery-validation -->
    <script src="<?php echo e(URL::asset('build/libs/jquery-validation/jquery.validate.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/js/pages/task-kanban.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/process-form.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/accessories-form.init.js')); ?>"></script>

    <script>
        function calculateTotalQty(input, index) {
            const maxValue = parseFloat(input.max);
            const currentValue = parseFloat(input.value);

            if (currentValue > maxValue) {
                toastr["error"](`Qty should not be greater than ${maxValue}`);
                input.value = '';
                return;
            }
            var total = 0;
            var balance = 0;
            var totalKgs = 0;
            var totalPercentage = 0;
            var totalBalance = 0;

            $('.qty').each(function() {
                total += Number($(this).val()) || 0;
            });

            $('#total-qty').text(Number(total).toFixed(2));

            var kgs = Number($(input).val()) * 45.359237;

            $('.kgs_' + index).text(Number(kgs).toFixed(2));
            $('.kgs_field_' + index).val(Number(kgs).toFixed(2));

            balance = maxValue - Number($(input).val());

            $('.balance_' + index).text(Number(balance).toFixed(2));
            $('.balance_field_' + index).val(Number(balance).toFixed(2));

            $('.balance').each(function() {
                totalBalance += Number($(this).text());
            });

            $('.kgs').each(function() {
                totalKgs += Number($(this).text()) || 0;
            });

            $('.kgs').each(function(index) {
                var percentage = (Number($(this).text()) / totalKgs) * 100;
                totalPercentage += percentage;
                $('.percentage_' + index).text(Number(percentage).toFixed(2));
                $('.percentage_field_' + index).val(Number(percentage).toFixed(2));
            });

            $('#total-kgs').text(Number(totalKgs).toFixed(2));
            $('#total-balance').text(Number(totalBalance).toFixed(2));

            $('#total-percentage').text(Number(totalPercentage).toFixed(2));

        }

        $(document).ready(function() {
            $('input[name^="yarn_purchase_order"][name$="[qty]"]').trigger('change');
        });
    </script>

    <?php if($errors->any()): ?>
        <script>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                toastr["error"]('<?php echo e($error); ?>');
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </script>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <script>
            toastr["success"]('<?php echo e(session('success')); ?>');
        </script>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <script>
            toastr["error"]('<?php echo e(session('error')); ?>');
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.departments.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\shafi_portal\resources\views/admin/department/orders/view.blade.php ENDPATH**/ ?>