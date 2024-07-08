<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Purchase_Order'); ?>
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
            Fabrication
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('translation.CartageSlips'); ?>
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form autocomplete="off" method="POST" class="needs-validation updateOrder-form"
                        enctype="multipart/form-data" id="updateOrder-form"
                        action="<?php echo e(route('admin.departments.cartage_slip.store', ['slug' => $department->slug])); ?>"
                        novalidate>
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="form_id" value="updateOrder-form">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="job-id-input" class="form-label">Job ID</label>
                                    <select class="select2 form-control" name="job_id" id="job-id-input"
                                        data-placeholder="Choose ..." required>
                                        <option>Select</option>
                                        <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($job->id); ?>"
                                                <?php echo e($slip->job_id == $job->id ? 'selected' : ''); ?>><?php echo e($job->number); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">Please select a valid job id.</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="orders-input" class="form-label">Orders</label>
                                    <select class="select2 form-control select2-multiple" name="orders[]" id="orders-input"
                                        data-placeholder="Choose ..." required multiple="multiple">
                                        <option>Select</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a valid orders.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" class="form-control" id="slipNo-input">
                                <div class="mb-3">
                                    <label for="slip-input" class="form-label">Slip No</label>
                                    <input type="text" name="slip_no" id="slip-input" value="<?php echo e($slip->slip_no); ?>"
                                        class="form-control" placeholder="Enter slip no" required />
                                    <div class="invalid-feedback">Please enter a slip no.</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="items-input" class="form-label">Item</label>
                                    <select class="select2 form-control select2-multiple" name="items[]" id="items-input"
                                        data-placeholder="Choose ..." required multiple="multiple">
                                        <option>Select</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a valid item.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="delivery-from-input" class="form-label">Delivery From</label>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <select class="form-control select2" id="from-type-input"
                                                value="<?php echo e(old('delivery_from_type')); ?>" required name="delivery_from_type">
                                                <option value="">Select</option>
                                                <option value="departments"
                                                    <?php echo e($slip->delivery_from_type == 'departments' ? 'selected' : ''); ?>>
                                                    Department</option>
                                                <option value="knitting"
                                                    <?php echo e($slip->delivery_from_type == 'knitting' ? 'selected' : ''); ?>>
                                                    Knitting House</option>
                                                <option value="dyeing"
                                                    <?php echo e($slip->delivery_from_type == 'dyeing' ? 'selected' : ''); ?>>
                                                    Dyeing House</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid deliver from type.</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <select class="form-control select2" id="delivery-from-input"
                                                value="<?php echo e(old('delivery_from_id')); ?>" required name="delivery_from_id">
                                                <option value="">Select</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid delivery from option.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="deliver-to-input" class="form-label">Delivery To</label>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <select class="form-control select2" id="to-type-input"
                                                value="<?php echo e(old('delivery_to_type')); ?>" required name="delivery_to_type">
                                                <option value="">Select</option>
                                                <option value="departments"
                                                    <?php echo e($slip->delivery_to_type == 'departments' ? 'selected' : ''); ?>>
                                                    Department</option>
                                                <option value="knitting"
                                                    <?php echo e($slip->delivery_to_type == 'knitting' ? 'selected' : ''); ?>>
                                                    Knitting House</option>
                                                <option value="dyeing"
                                                    <?php echo e($slip->delivery_to_type == 'dyeing' ? 'selected' : ''); ?>>
                                                    Dyeing House</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid deliver to type.</div>
                                        </div>
                                        <div class="col-lg-8">
                                            <select class="form-control select2" id="delivery-to-input"
                                                value="<?php echo e(old('delivery_to_id')); ?>" required name="delivery_to_id">
                                                <option value="">Select</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid delivery to option.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="driver-name-input" class="form-label">Driver Name</label>
                                    <input type="text" name="driver_name" id="driver-name-input" class="form-control"
                                        placeholder="Enter driver name" value="<?php echo e($slip->driver_name); ?>" required />
                                    <div class="invalid-feedback">Please enter a valid diver name.</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="driver-cell-no-input" class="form-label">Driver's Cell No</label>
                                    <input type="text" name="driver_cell_no" id="driver-cell-no-input"
                                        class="form-control" value="<?php echo e($slip->driver_cell_no); ?>"
                                        placeholder="Enter driver cell no" required />
                                    <div class="invalid-feedback">Please enter a valid driver cell no.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="vehicle-no-input" class="form-label">Vehicle No</label>
                                    <input type="text" name="vehicle_no" id="vehicle-no-input" class="form-control"
                                        placeholder="Enter vehicle no" value="<?php echo e($slip->vehicle_no); ?>" required />
                                    <div class="invalid-feedback">Please enter a valid vehicle no.</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="vehicle-type-input" class="form-label">Vehicle Type</label>
                                    <input type="text" name="vehicle_type" id="vehicle-type-input"
                                        class="form-control" value="<?php echo e($slip->vehicle_type); ?>"
                                        placeholder="Enter vehicle type" required />
                                    <div class="invalid-feedback">Please enter a slip no.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="amount-input" class="form-label">Amount</label>
                                    <input type="text" name="amount" id="amount-input" class="form-control"
                                        placeholder="Enter amount" value="<?php echo e($slip->amount); ?>" required />
                                    <div class="invalid-feedback">Please enter a valid amount.</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="amount-in-words-input" class="form-label">Amount In Words</label>
                                    <input type="text" name="amount_in_words" id="amount-in-words-input"
                                        class="form-control" value="<?php echo e($slip->amount_in_words); ?>"
                                        placeholder="Enter amount in words" required />
                                    <div class="invalid-feedback">Please enter a valid amount in words.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name-input" class="form-label">File</label>
                                    <div>
                                        <input type="file" required name="attachment" id="attachment"
                                            class="form-control" />
                                        <a href="<?php echo e($slip->attachment->image_path); ?>" class="mt-4" target="_blank">
                                            View Document</a>
                                        <div class="invalid-feedback">Please enter a valid file.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name-input" class="form-label">Status</label>
                                    <div>
                                        <input type="checkbox" name="status" value="1" id="switch6"
                                            switch="primary" />
                                        <label for="switch6" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" id="addRange-btn" class="btn btn-success">Add Cartage
                                    Slip</button>

                            </div>
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
    <script src="<?php echo e(URL::asset('build/js/pages/form-repeater.int.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/table-edits/build/table-edits.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/table-editable.int.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $(document).ready(function() {
            $('#from-type-input').trigger('change');
            $('#to-type-input').trigger('change');
            $('#job-id-input').trigger('change');
            $('#orders-input').trigger('change');
        });

        $('#from-type-input').on('change', function(event) {
            event.preventDefault();
            var selected = $(this).val();
            $.ajax({
                url: "/admin/fetch-data-by-type",
                type: 'GET',
                dataType: 'json',
                data: {
                    "type": selected
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data, status, xhr) {
                    $('#delivery-from-input').html(
                        '<option value="">Select delivery from</option>');
                    if (selected == "departments") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-from-input").append('<option value="' +
                                value.id + '">' + value.name + '</option>');
                        });
                    } else if (selected == "knitting") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-from-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    } else if (selected == "dyeing") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-from-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    }

                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        });

        $('#to-type-input').on('change', function(event) {
            event.preventDefault();
            var selected = $(this).val();
            $.ajax({
                url: "/admin/fetch-data-by-type",
                type: 'GET',
                dataType: 'json',
                data: {
                    "type": selected
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data, status, xhr) {
                    $('#delivery-to-input').html(
                        '<option value="">Select delivery to</option>');
                    if (selected == "departments") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-to-input").append('<option value="' +
                                value.id + '">' + value.name + '</option>');
                        });
                    } else if (selected == "knitting") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-to-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    } else if (selected == "dyeing") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-to-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    }

                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        });

        $('#job-id-input').on('change', function(event) {
            event.preventDefault();
            var selected = $(this).val();
            <?php $__currentLoopData = $slip->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                var selectedOrders = [<?php echo e($item->order_item->order_id); ?>];
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            console.log(selectedOrders);
            $.ajax({
                url: "/admin/fetch-orders-by-job-id",
                type: 'GET',
                dataType: 'json',
                data: {
                    "job_id": selected
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data, status, xhr) {
                    $('#orders-input').html(
                        '<option value="">Select order</option>');

                    var selectedOrders = <?php echo json_encode($slip->items->pluck('order_item.order_id')->toArray(), 15, 512) ?>;

                    $.each(data.result, function(key, value) {
                        var selected = selectedOrders.includes(value.id) ? 'selected' : '';
                        $("#orders-input").append('<option value="' + value.id + '" ' +
                            selected + '>' + value.code + '</option>');
                    });

                    // $.each(data.result, function(key, value) {
                    //     $("#orders-input").append('<option value="' +
                    //         value.id + '" >' + value.code + '</option>');
                    // });
                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        });

        $('#orders-input').on('change', function(event) {
            event.preventDefault();
            var selected = $(this).val();
            $.ajax({
                url: "/admin/fetch-order-items-by-order-id",
                type: 'GET',
                dataType: 'json',
                data: {
                    "order_id": selected
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data, status, xhr) {
                    $('#items-input').html(
                        '<option value="">Select item</option>');
                    $.each(data.result, function(key, value) {
                        $("#items-input").append('<option value="' +
                            value.id + '">' + value.article_style_no + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        });


        $("#updateOrder-form").submit(function(e) {
            e.preventDefault();
            saveFormState();
        });

        function numberToWords(number) {
            var digit = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
            var elevenSeries = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen',
                'eighteen', 'nineteen'
            ];
            var countingByTens = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
            var shortScale = ['', 'thousand', 'million', 'billion', 'trillion'];

            number = number.toString();
            number = number.replace(/[\, ]/g, '');
            if (number != parseFloat(number)) return 'not a number';
            var x = number.indexOf('.');
            if (x == -1) x = number.length;
            if (x > 15) return 'too big';
            var n = number.split('');
            var str = '';
            var sk = 0;
            for (var i = 0; i < x; i++) {
                if ((x - i) % 3 == 2) {
                    if (n[i] == '1') {
                        str += elevenSeries[Number(n[i + 1])] + ' ';
                        i++;
                        sk = 1;
                    } else if (n[i] != 0) {
                        str += countingByTens[n[i] - 2] + ' ';
                        sk = 1;
                    }
                } else if (n[i] != 0) {
                    str += digit[n[i]] + ' ';
                    if ((x - i) % 3 == 0) str += 'hundred ';
                    sk = 1;
                }
                if ((x - i) % 3 == 1) {
                    if (sk) str += shortScale[(x - i - 1) / 3] + ' ';
                    sk = 0;
                }
            }
            if (x != number.length) {
                var y = number.length;
                str += 'point ';
                for (var i = x + 1; i < y; i++) str += digit[n[i]] + ' ';
            }
            str = str.replace(/\number+/g, ' ');
            return str.trim() + ".";

        }

        $('#amount-input').on('input', function() {
            var amount = $(this).val();
            var words = numberToWords(amount);
            $('#amount-in-words-input').val(words);
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

<?php echo $__env->make('layouts.departments.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/admin/department/cartage_slip/edit.blade.php ENDPATH**/ ?>