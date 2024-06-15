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

    <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST" id="yarnPurchaseOrder-form"
        action="<?php echo e(route('admin.departments.yarn_purchase_order.store', ['slug' => $department->slug])); ?>">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order_id" class="form-label">Order </label>
                                    <select name="order_id" id="order_id" class="form-control select2" required>
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($order->id); ?>"
                                                <?php echo e(old('order_id') == $order->id ? 'selected' : ''); ?>><?php echo e($order->code); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid order no.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="job_id" class="form-label">Job No</label>
                                    <select name="job_id" id="job_id" class="form-control select2" required>
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($job->id); ?>"
                                                <?php echo e(old('job_id') == $job->id ? 'selected' : ''); ?>><?php echo e($job->number); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid job no.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="count_id" class="form-label">Count </label>
                                    <select name="count_id" id="count_id" class="form-control select2" required>
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $counts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($count->id); ?>"
                                                <?php echo e(old('count_id') == $count->id ? 'selected' : ''); ?>>
                                                <?php echo e($count->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid counts no.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fiber_id" class="form-label">Fiber</label>
                                    <select name="fiber_id" id="fiber_id" class="form-control select2" required>
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $fibers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fiber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($fiber->id); ?>"
                                                <?php echo e(old('fiber_id') == $fiber->id ? 'selected' : ''); ?>><?php echo e($fiber->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid fiber.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fabric_construction_id" class="form-label">Fabric Construction </label>
                                    <select name="fabric_construction_id" id="fabric_construction_id"
                                        class="form-control select2" required>
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $fabricConstructions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fabricConstruction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($fabricConstruction->id); ?>"
                                                <?php echo e(old('fabric_construction_id') == $fabricConstruction->id ? 'selected' : ''); ?>>
                                                <?php echo e($fabricConstruction->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid fiber construction.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mill_id" class="form-label">Mill</label>
                                    <select name="mill_id" id="mill_id"
                                        data-parsley-required-message="You must select at least one option."
                                        class="form-control select2" required>
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $mills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($mill->id); ?>"
                                                <?php echo e(old('mill_id') == $mill->id ? 'selected' : ''); ?>><?php echo e($mill->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid job no.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="agent_id" class="form-label">Agent </label>
                                    <select name="agent_id" id="agent_id" class="form-control select2">
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($agent->id); ?>"
                                                <?php echo e(old('agent_id') == $agent->id ? 'selected' : ''); ?>><?php echo e($agent->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid agent.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="terms_of_delivery_id" class="form-label">Terms Of Delivery</label>
                                    <select name="terms_of_delivery_id" id="terms_of_delivery_id"
                                        class="form-control select2" required>
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $termsOfDelivery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $termsOfDeliver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($termsOfDeliver->id); ?>"<?php echo e(old('terms_of_delivery_id') == $termsOfDeliver->id ? 'selected' : ''); ?>>
                                                <?php echo e($termsOfDeliver->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid terms of delivery.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="contract_no" class="form-label">Contract No</label>
                                    <input class="form-control" type="number" name="contract_no"
                                        value="<?php echo e(old('contract_no')); ?>" placeholder="Enter contract no" required
                                        id="contract_no">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid contract no.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 border-end">
                                <div class="mb-3">
                                    <label for="date_of_purchase" class="form-label">Date of Purchase</label>
                                    <div class="input-group" id="date_of_purchase_cont">
                                        <input type="text" class="form-control" placeholder="dd M, yyyy"
                                            value="<?php echo e(old('date_of_purchase') ? old('date_of_purchase') : date('d M, Y')); ?>"
                                            id="date_of_purchase" data-date-format="dd M, yyyy" name="date_of_purchase"
                                            data-date-container='#date_of_purchase_cont' data-provide="datepicker">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid purchase date.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="gst_no" class="form-label">Terms of Payment</label>
                                    <div class="input-group">
                                        <input type="number" value="<?php echo e(old('terms_of_payment')); ?>"
                                            name="terms_of_payment" class="form-control"
                                            placeholder="Enter terms of payment">
                                        <span class="input-group-text">Days</span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid payment terms.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="delivery_date_cont" class="form-label">Delivery Date</label>
                                    <div class="input-group" id="delivery_date_cont">
                                        <input type="text" class="form-control" placeholder="dd M, yyyy"
                                            value="<?php echo e(old('delivery_date') ? old('delivery_date') : date('d M, Y')); ?>"
                                            id="delivery_date" data-date-format="dd M, yyyy" name="delivery_date"
                                            data-date-container='#delivery_date_cont'
                                            onchange="calculateCompletionIn(this)" data-provide="datepicker">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid delivery date.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Lbs</label>
                                    <input type="number" class="form-control" onkeyup="calculateKGsBags(this)"
                                        id="lbs" placeholder="Enter Lbs" value="<?php echo e(old('lbs')); ?>" required
                                        name="lbs">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid lbs.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Kgs</label>
                                    <input type="number" class="form-control" id="kgs" placeholder="Enter Kgs"
                                        value="<?php echo e(old('kgs')); ?>" readonly required name="kgs">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid kgs.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 border-end">
                                <div class="mb-3 ">
                                    <label for="qty" class="form-label">Qty</label>
                                    <div class="btn-group dropup">
                                        <input type="hidden" name="unit" id="unit" value="Bags">
                                        <input type="number" class="form-control" id="qty"
                                            placeholder="Enter Qty" value="<?php echo e(old('qty')); ?>" readonly required
                                            name="qty">
                                        <button type="button" class="btn btn-primary dropdown-toggle" id="unitButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Bags
                                        </button>
                                        <div class="dropdown-menu" id="unitDropdown">
                                            <a class="dropdown-item" href="#" data-unit="Bags">Bags</a>
                                            <a class="dropdown-item" href="#" data-unit="Carton">Carton</a>
                                        </div>
                                    </div>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid bags number.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Price/LB</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="price_per_lb"
                                            placeholder="Enter price/lb" onchange="calculateAmount(this)" step="0.10"
                                            value="<?php echo e(old('price_per_lb')); ?>" required name="price_per_lb">
                                        <span class="input-group-text">Rs</span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid bags number.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Amount</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="amount"
                                            placeholder="Enter amount" readonly value="<?php echo e(old('amount')); ?>" required
                                            name="amount">
                                        <span class="input-group-text">Rs</span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid amount.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Amount With GST</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="with_gst"
                                            placeholder="Enter amount with gst" readonly value="<?php echo e(old('with_gst')); ?>"
                                            required name="with_gst">
                                        <span class="input-group-text">Rs</span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid amount with gst.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="completion_in" class="form-label">Completion In</label>
                                    <div class="input-group">
                                        <input type="number" id="completion_in" value="<?php echo e(old('completion_in') ?: 0); ?>"
                                            name="completion_in" class="form-control" readonly
                                            placeholder="Enter terms of payment in days">
                                        <span class="input-group-text">Days</span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid completion time.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 border-end">
                                <div class="mb-3">
                                    <label for="delivered" class="form-label">Delivered</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" onchange="calculateBalance(this)"
                                            placeholder="Enter delivered" value="<?php echo e(old('delivered')); ?>"
                                            name="delivered" step="0.01" required>
                                        <div class="input-group-text unit">
                                            Bags
                                        </div>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid delivered count.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="balance" class="form-label">Balance</label>
                                    <div class="input-group">
                                        <input type="number" placeholder="Enter balance" name="balance"
                                            class="form-control" id="balance" value="<?php echo e(old('balance')); ?>" readonly
                                            required>
                                        <div class="input-group-text unit">
                                            Bags
                                        </div>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid balance.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="invoice_of" class="form-label">Invoice of</label>
                                    <input class="form-control" type="text" name="invoice_of"
                                        value="<?php echo e(old('invoice_of')); ?>" placeholder="Enter invocie of" required
                                        id="invoice_of">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid invoice of.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-3 border-end">
                                <div class="mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea type="number" placeholder="Enter remarks" name="remarks" class="form-control" id="remarks"><?php echo e(old('remarks')); ?></textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid remarks.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="submit">Ceeate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function calculateKGsBags(input) {
            var kgs = 0;
            var lbs = $(input).val();
            kgs = lbs / 2.20462262;
            var qty = kgs / 45.359237;
            $('#kgs').val(parseFloat(kgs).toFixed(2));
            $('#qty').val(parseFloat(qty).toFixed(2));
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
            var bags = $('#qty').val();

            if (bags == "") {
                toastr["error"]('Please define the qty first');
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
                $('.unit').each(function() {
                    $(this).text(selectedUnit);
                });
            });
        });

        function saveFormState() {
            let form = document.getElementById('yarnPurchaseOrder-form');
            let formData = new FormData(form);
            // Convert FormData to an object
            let data = {};
            formData.forEach((value, key) => {
                if (!data[key]) {
                    data[key] = value;
                    return;
                }
                if (!Array.isArray(data[key])) {
                    data[key] = [data[key]];
                }
                data[key].push(value);
            });
            data['form_id'] = 'yarnPurchaseOrder-form';

            axios.post('<?php echo e(route('admin.save.form.state')); ?>', data)
                .then(response => {
                    form.submit();
                })
                .catch(error => {
                    console.error('Error saving form state:', error);
                });
        }

        function getFormState() {
            axios.get('<?php echo e(route('admin.get.form.state', ['form_id' => 'yarnPurchaseOrder-form'])); ?>')
                .then(response => {
                    if (response.data.form_state) {
                        // Populate form fields with saved state
                        let formState = response.data.form_state;
                        for (let key in formState) {
                            if (formState.hasOwnProperty(key)) {

                                let field = document.querySelector(`[name="${key}"]`);
                                if (field) {
                                    if (field.type === 'checkbox') {
                                        field.checked = formState[key] === '1' ? true : false;
                                    } else if (field.tagName === 'SELECT') {
                                        field.value = formState[key];
                                    } else {
                                        field.value = formState[key];
                                    }
                                }
                            }
                        }
                        $('#from-type-input').trigger('change');
                        $('#to-type-input').trigger('change');
                        $('#job-id-input').trigger('change');
                        $(".select2").select2();
                    }
                })
                .catch(error => {
                    console.error('Error retrieving form state:', error);
                });
        }

        $("#yarnPurchaseOrder-form").submit(function(e) {
            e.preventDefault();
            saveFormState();
        });

        window.onload = getFormState;
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

<?php echo $__env->make('layouts.departments.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/admin/department/yarn_purchase_order/create.blade.php ENDPATH**/ ?>