<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Orders'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <?php echo app('translator')->get('translation.Departments'); ?>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?>
            <?php echo e($department->name); ?>

        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('translation.YarnPurchaseOrder'); ?>
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Job No</th>
                                <th>Count</th>
                                <th>Fiber</th>
                                <th>Fabric Construction</th>
                                <th>Mill</th>
                                <th>Terms Of Delivery</th>
                                <th>Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo e($yarn_po->order->code); ?></td>
                                <td><?php echo e($yarn_po->job->number); ?></td>
                                <td><?php echo e($yarn_po->count->name); ?></td>
                                <td><?php echo e($yarn_po->fiber->name); ?></td>
                                <td><?php echo e($yarn_po->fabric_construction->name); ?></td>
                                <td><?php echo e($yarn_po->mill->name); ?></td>
                                <td><?php echo e($yarn_po->terms_of_delivery->name); ?></td>
                                <td><?php echo e($yarn_po->agent->name); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Contract No</th>
                                <th>Date of Purchase</th>
                                <th>Terms of Payment</th>
                                <th>Delivery Date</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo e($yarn_po->contract_no); ?></td>
                                <td><?php echo e($yarn_po->date_of_purchase); ?></td>
                                <td><?php echo e($yarn_po->terms_of_payment); ?></td>
                                <td><?php echo e($yarn_po->delivery_date); ?></td>
                                <td><?php echo e($yarn_po->remarks); ?></td>

                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Lbs</th>
                                <th>Kgs</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Price/Lb</th>
                                <th>Amount</th>
                                <th>Amount With GST</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo e($yarn_po->lbs); ?></td>
                                <td><?php echo e($yarn_po->kgs); ?></td>
                                <td><?php echo e($yarn_po->qty); ?></td>
                                <td><?php echo e($yarn_po->unit); ?></td>
                                <td><?php echo e($yarn_po->price_per_lb); ?></td>
                                <td><?php echo e($yarn_po->amount); ?></td>
                                <td><?php echo e($yarn_po->with_gst); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Completion In</th>
                                <th>Delivered</th>
                                <th>Balance</th>
                                <th>Invoice of</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo e($yarn_po->completion_in); ?></td>
                                <td><?php echo e($yarn_po->delivered); ?></td>
                                <td><?php echo e($yarn_po->balance); ?></td>
                                <td><?php echo e($yarn_po->invoice_of); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="<?php echo e(route('admin.departments.yarn_po_receiving.store', ['slug' => $department->slug])); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="yarn_po_id" value="<?php echo e($yarn_po->id); ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="gst_no" class="form-label">Received</label>
                                    <div class="input-group">
                                        <input type="number" max="<?php echo e($yarn_po->delivered); ?>" step="0.01"
                                            name="received_qty" class="form-control" placeholder="Enter received qty">
                                        <span class="input-group-text"><?php echo e($yarn_po->unit); ?></span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid received qty.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
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

    <script src="<?php echo e(URL::asset('build/libs/jquery.repeater/jquery.repeater.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/order-form-repeaterr.int.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/table-edits/build/table-edits.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/table-editable.int.js')); ?>"></script>
    <script>
        function calculateKGsBags(input) {
            var kgs = 0;
            var lbs = $(input).val();
            kgs = lbs / 2.20462262;
            var bags = kgs / 45.359237;
            $('#kgs').val(parseFloat(kgs).toFixed(2));
            $('#bags').val(parseFloat(bags).toFixed(2));
        }

        function calculateAmount(input) {
            var amount_per_lbs = $(input).val();
            var lbs = $('#lbs').val();
            var amount = amount_per_lbs * lbs;
            $('#amount').val(parseFloat(amount).toFixed(2));
            var with_gst = amount * (1 + 0.18);
            $('#with_gst').val(parseFloat(with_gst).toFixed(2));
        }

        function calculateBalance(input) {
            var delivered = $(input).val();
            var bags = $('#bags').val();

            if (bags == "") {
                toastr["error"]('Please define the bags first');
                return;
            }
            $(input).attr({
                "max": bags,
                "min": 0
            });

            var balance = bags - delivered;
            $('#balance').val(parseFloat(balance).toFixed(2));
        }

        function calculateCompletionIn(input) {
            var delivery_date = $(input).val();
            var purchase_date = $('#date_of_purchase').val();

            // Ensure both dates are provided
            if (delivery_date && purchase_date) {

                // Convert the date strings to Date objects
                var deliveryDateObj = new Date(delivery_date);
                var purchaseDateObj = new Date(purchase_date);

                // Calculate the difference in time (milliseconds)
                var timeDifference = deliveryDateObj - purchaseDateObj;

                // Convert the time difference from milliseconds to days
                var differenceInDays = timeDifference / (1000 * 60 * 60 * 24);

                // Set the difference in days to the input field
                $('#completion_in').val(differenceInDays);
            } else {
                toastr["error"]('Please provide both dates');
            }
        }

        $(document).ready(function() {
            $('#unitDropdown .dropdown-item').on('click', function(event) {
                event.preventDefault();
                var selectedUnit = $(this).data('unit');
                $('#unit').val(selectedUnit);
                $('#unitButton').text(selectedUnit);
            });
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

<?php echo $__env->make('layouts.departments.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/admin/department/yarn_purchase_order/receiving/create.blade.php ENDPATH**/ ?>