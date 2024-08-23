

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
            <?php echo app('translator')->get('translation.Orders'); ?>
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="repeater needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="<?php echo e(route('admin.departments.orders.update', ['slug' => $department->slug, 'order' => $order->id])); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="supplier" class="form-label">Customer's PO Number</label>
                                    <input type="text" name="customer_po_number"
                                        value="<?php echo e($order->customer_po_number ? $order->customer_po_number : old('customer_po_number')); ?>"
                                        class="form-control">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid po no.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="moobile_no" class="form-label">Job No</label>
                                    <select name="job_id" class="form-control select2" required>
                                        <option>Select</option>
                                        <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($job->id); ?>"
                                                <?php echo e($order->job_id == $job->id ? 'selected' : ''); ?>><?php echo e($job->number); ?>

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
                                    <label for="customer" class="form-label">Customer</label>
                                    <select class="form-control select2" name="customer_id">
                                        <option>Select</option>
                                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($client->id); ?>"
                                                <?php echo e($order->customer_id == $client->id ? 'selected' : ''); ?>>
                                                <?php echo e($client->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid customer.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="serial_no" class="form-label">PO Receive Date</label>
                                    <input type="date" class="form-control" id="po_receive_date"
                                        placeholder="PO Receive Date"
                                        value="<?php echo e($order->po_receive_date ? $order->po_receive_date : old('po_receive_date')); ?>"
                                        required name="po_receive_date">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the po receive date.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Delivery Date</label>
                                    <input type="date" class="form-control" id="delivery_date" placeholder="Deliery Date"
                                        value="<?php echo e($order->delivery_date ? $order->delivery_date : old('delivery_date')); ?>"
                                        required name="delivery_date">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid delivery date.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gst_no" class="form-label">Payment Terms</label>
                                    <select name="payment_term_id" class="form-control select2">
                                        <option>Select</option>
                                        <?php $__currentLoopData = $paymentTerms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentTerm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($paymentTerm->id); ?>"
                                                <?php echo e($order->payment_term_id == $paymentTerm->id ? 'selected' : ''); ?>>
                                                <?php echo e($paymentTerm->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid payment terms.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Fabric Construction</label>
                                    <select name="fabric_construction_id" class="form-control select2">
                                        <option>Select</option>
                                        <?php $__currentLoopData = $fabricConstructions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fabricConstruction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($fabricConstruction->id); ?>"
                                                <?php echo e($order->fabric_construction_id == $fabricConstruction->id ? 'selected' : ''); ?>>
                                                <?php echo e($fabricConstruction->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid fabric cosntruction.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order_quantity" class="form-label">Total Order Quantity</label>
                                    <input type="text" class="form-control" id="order_quantity"
                                        placeholder="Total Order Quantity"
                                        value="<?php echo e($order->order_quantity ? $order->order_quantity : old('order_quantity')); ?>"
                                        required name="order_quantity">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid order quantity.
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div data-repeater-list="group-a">
                            <?php
                                $sumQty = 0;
                            ?>
                            <?php $__currentLoopData = $order->order_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div data-repeater-item class="row data-repeater-item">
                                    <div class="mb-3 col-lg-1">
                                        <label for="article_style_no-<?php echo e($key); ?>">Article No</label>
                                        <input type="text" id="article_style_no-<?php echo e($key); ?>"
                                            value="<?php echo e($order_item->article_style_no ? $order_item->article_style_no : old('article_style_no')); ?>"
                                            name="article_style_no" class="form-control"
                                            placeholder="Enter Item Article No" />
                                        <input type="hidden" name="order_item_id" value="<?php echo e($order_item->id); ?>">
                                    </div>

                                    <div class="mb-3 col-lg-2">
                                        <label for="article_style_id-<?php echo e($key); ?>">Title / Product Type</label>
                                        <select name="article_style_id" id="article_style_id-<?php echo e($key); ?>"
                                            class="form-control select2">
                                            <option>Select</option>
                                            <?php $__currentLoopData = $articleStyles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articleStyle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($articleStyle->id); ?>"
                                                    <?php echo e($order_item->article_style_id == $articleStyle->id ? 'selected' : ''); ?>>
                                                    <?php echo e($articleStyle->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-lg-2">
                                        <label for="description-<?php echo e($key); ?>">Description</label>
                                        <input type="text" id="description-<?php echo e($key); ?>" name="description"
                                            value="<?php echo e($order_item->description); ?>" class="form-control"
                                            placeholder="Description" />
                                    </div>

                                    <div class="mb-3 col-lg-1">
                                        <label for="range_id-<?php echo e($key); ?>" class="form-label">Range</label>
                                        <select name="range_id" class="form-control select2">
                                            <option>Select</option>
                                            <?php $__currentLoopData = $ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($range->id); ?>"
                                                    <?php echo e($order_item->range_id == $range->id ? 'selected' : ''); ?>>
                                                    <?php echo e($range->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-lg-1">
                                        <label for="size-<?php echo e($key); ?>">Size</label>
                                        <select name="size" id="size-<?php echo e($key); ?>"
                                            class="form-control select2 select2-multiple" multiple>
                                            <?php $__currentLoopData = App\Constants\DefaultValues::SIZES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($size); ?>"
                                                    <?php echo e(in_array($size, json_decode($order_item->sizes)) ? 'selected' : ''); ?>>
                                                    <?php echo e($size); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-lg-1">
                                        <label for="color">GSM</label>
                                        <input type="text" id="gsm" name="gsm" required
                                            value="<?php echo e($order_item->gsm); ?>" class="form-control" placeholder="GSM" />
                                    </div>
                                    <div class="mb-3 col-lg-1">
                                        <label for="color-<?php echo e($key); ?>">Color</label>
                                        <input type="text" id="color-<?php echo e($key); ?>" name="color"
                                            value="<?php echo e($order_item->color); ?>" class="form-control colorpicker-showalpha"
                                            placeholder="Color" />
                                    </div>
                                    <div class="mb-3 col-lg-1">
                                        <label for="qty-<?php echo e($key); ?>">Qty</label>
                                        <input type="number" id="qty-<?php echo e($key); ?>"
                                            value="<?php echo e($order_item->qty); ?>" onchange="calculateQnty(this)"
                                            onkeyup="calculateQnty(this)" name="qty" class="form-control"
                                            placeholder="Qty" />
                                    </div>
                                    <div class="mb-3 col-lg-1">
                                        <label for="unit-<?php echo e($key); ?>">Unit</label>
                                        <input type="text" id="unit-<?php echo e($key); ?>"
                                            value="<?php echo e($order_item->unit); ?>" name="unit" class="form-control"
                                            placeholder="Unit" />
                                    </div>

                                    <div class="col-lg-1 align-self-center">
                                        <div class="d-grid">
                                            <span data-repeater-delete type="button"><i
                                                    class="bx bx-trash-alt font-size-20 text-danger verti-timeline"></i></span>

                                        </div>
                                    </div>
                                </div>
                                <?php
                                    $sumQty += $order_item->qty;
                                ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0 add-row"
                                    value="Add" />
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-editable table-nowrap align-middle table-edits">
                                            <tbody>
                                                <tr>
                                                    <td>Total Order Qty :</td>
                                                    <td id="total_qty"><?php echo e($sumQty); ?></td>
                                                    <td style="width: 50px">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
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
        function calculateQnty(input) {
            var total = 0;
            var definedQty = parseInt($('#order_quantity').val());

            $('[data-repeater-item]').each(function() {
                var qty = parseFloat($(this).find('[name^="group-a"][name$="[qty]"]').val()) || 0;
                total += qty;
            });

            $('#total_qty').text(total);

        }
        $(".select2").each(function() {
            $(this).select2({
                placeholder: "Select"
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

<?php echo $__env->make('layouts.departments.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\shafi_portal\resources\views/admin/department/orders/edit.blade.php ENDPATH**/ ?>