

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
            Edit <?php echo app('translator')->get('translation.YarnProgram'); ?> Form
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="repeater needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="<?php echo e(route('admin.departments.yarn_program.update', ['slug' => $department->slug, 'yarn_program' => $yarnProgram->id])); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="job_id" class="form-label">Job No</label>
                                    <select name="job_id" id="job-id-input" class="form-control select2" required>
                                        <option>Select</option>
                                        <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($job->id); ?>"
                                                <?php echo e($yarnProgram->job_id == $job->id ? 'selected' : ''); ?>>
                                                <?php echo e($job->number); ?></option>
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="moobile_no" class="form-label">Name</label>
                                    <input type="text" name="name" placeholder="Enter name"
                                        value="<?php echo e($yarnProgram->name); ?>" class="form-control">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid name
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="orders-row">
                            <div id="repeater-container">
                                <table class="table main_table">
                                    <thead>
                                        <tr>
                                            <th>Job#</th>
                                            <?php $__currentLoopData = $yarnProgram->job->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <th><?php echo e($order->fabric_construction->name); ?> (<?php echo e($order->code); ?>)</th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <th>Total Kgs</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $total_kgs = 0;
                                        ?>
                                        <tr>
                                            <td><?php echo e($yarnProgram->job->number); ?></td>
                                            <?php $__currentLoopData = $yarnProgram->job->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Qty:
                                                                    <?php echo e($order->order_quantity); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <div class="input-group">
                                                                    <input type="hidden" name="order_id[]"
                                                                        value="<?php echo e($order->id); ?>">
                                                                    <input type="number"
                                                                        id="required_kgs_<?php echo e($key); ?>"
                                                                        value="<?php echo e($yarnProgram->items->where('order_id', $order->id)->first()->required_kgs); ?>"
                                                                        name="required_kgs[]" class="form-control"
                                                                        min="0" placeholder="Enter required kgs">
                                                                    <span class="input-group-text">Kgs</span>
                                                                </div>
                                                                <div class="valid-feedback">
                                                                    Looks good!
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Enter the valid kgs.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <?php
                                                    $total_kgs += $yarnProgram->items
                                                        ->where('order_id', $order->id)
                                                        ->first()->required_kgs;
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td><?php echo e($total_kgs); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                                    $totalKgs = 0;
                                    $totalBags = 0;
                                ?>
                                <?php $__currentLoopData = $yarnProgram->job->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <h5><?php echo e($order->fabric_construction->name); ?> (<?php echo e($order->code); ?>)
                                            </h5>

                                            <div class="repeater-group-<?php echo e(App\Helper\Helper::indexToAlphabet($key)); ?>">
                                                <div
                                                    data-repeater-list="group-<?php echo e(App\Helper\Helper::indexToAlphabet($key)); ?>">
                                                    <?php $__currentLoopData = $yarnProgram->items->where('order_id', $order->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div data-repeater-item class="row">
                                                            <div class="mb-3 col-lg-2">
                                                                <label for="article_style_no">Count</label>
                                                                <select class="form-control"
                                                                    onchange="getData(this, <?php echo e($key); ?>)"
                                                                    name="count">
                                                                    <?php $__currentLoopData = $counts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($count->id); ?>"
                                                                            <?php echo e($item->count_id == $count->id ? 'selected' : ''); ?>>
                                                                            <?php echo e($count->name); ?>

                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-lg-3">
                                                                <label for="article_style_no">Fiber</label>
                                                                <select class="form-control" name="fiber">
                                                                    <?php $__currentLoopData = $fibers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fiber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($fiber->id); ?>"
                                                                            <?php echo e($item->fiber_id == $fiber->id ? 'selected' : ''); ?>>
                                                                            <?php echo e($fiber->name); ?>

                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-lg-2">
                                                                <label for="description">Percentage</label>
                                                                <input type="number" id="percentage" max="100"
                                                                    onfocusout="calculateKgs(this, <?php echo e($key); ?>)"
                                                                    onchange="calculateKgs(this, <?php echo e($key); ?>)"
                                                                    value="<?php echo e($item->percentage); ?>" required
                                                                    name="percentage" class="form-control"
                                                                    placeholder="%" />
                                                            </div>
                                                            <div class="mb-3 col-lg-2">
                                                                <label for="credit_days" class="form-label">Total
                                                                    Kgs</label>
                                                                <input type="number" id="total_kgs<?php echo e($key); ?>"
                                                                    value="<?php echo e($item->kgs); ?>" readonly required
                                                                    name="kgs" class="form-control"
                                                                    placeholder="Total Kgs" />
                                                            </div>
                                                            <div class="mb-3 col-lg-2">
                                                                <label for="color">Total Bags</label>
                                                                <input type="number" id="total_bags<?php echo e($key); ?>"
                                                                    readonly name="bags" required
                                                                    value="<?php echo e($item->bags); ?>" class="form-control"
                                                                    placeholder="Total Bags" />
                                                            </div>
                                                            <div class="col-lg-1 align-self-center">
                                                                <div class="d-grid">
                                                                    <span data-repeater-delete type="button">
                                                                        <i
                                                                            class="bx bx-trash-alt font-size-20 text-danger verti-timeline">
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            $totalKgs += $item->kgs;
                                                            $totalBags += $item->bags;
                                                        ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input data-repeater-create="group-b" type="button"
                                                            class="btn btn-success mt-3 mt-lg-0" value="Add" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <table class="table footer_table">
                                    <thead>
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th id="sum_kgs"><?php echo e(number_format($totalKgs, 2)); ?> Kgs</th>
                                            <th id="sum_bags"><?php echo e(number_format($totalBags, 2)); ?> Bags</th>
                                        </tr>
                                    </thead>
                                </table>
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

    <script src="<?php echo e(URL::asset('build/libs/jquery.repeater/jquery.repeater.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/yarn-program-form-repeater.int.js')); ?>"></script>

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

    <script src="<?php echo e(URL::asset('build/libs/table-edits/build/table-edits.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/table-editable.int.js')); ?>"></script>
    <script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // $(document).ready(function() {
        //     $('#job-id-input').trigger('change');
        // });

        function calculateQnty(input) {
            var total = 0;
            var definedQty = parseInt($('#order_quantity').val());

            $('[data-repeater-item]').each(function() {
                var qty = parseFloat($(this).find('[name^="group-a"][name$="[qty]"]').val()) || 0;
                total += qty;
            });

            $('#total_qty').text(total);

        }

        $('#job-id-input').on('change', function(event) {
            event.preventDefault();
            var selected = $(this).val();
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
                    $('#repeater-container').html('');
                    var TotalQty = 0;
                    var mainTableHtml = `<table class="table main_table">
                                <thead>
                                    <tr>
                                    <th>Job#</th>
                                    `;
                    $.each(data.result, function(key1, value) {

                        mainTableHtml += `
                                        <th>` + value.fabric_construction.name + ` (` + value.code + `)</th>
                                    `;
                    });

                    mainTableHtml += `<th>Total Kgs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>` + data.result[0].job.number + `</td>
                                        `;
                    $.each(data.result, function(key1, value) {
                        mainTableHtml += `<td>
                            <div class="row">
                                <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Qty: ` + value.order_quantity + `</label>
                                    </div>
                                    </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="hidden" name="order_id[]" value="` + value.id + `">
                                        <input type="number" id="required_kgs_` + key1 + `"
                                            name="required_kgs[]" class="form-control" min="0"
                                            placeholder="Enter required kgs">
                                        <span class="input-group-text">Kgs</span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid kgs.
                                    </div>
                                </div>
                            </div>
                            </div>
                            ` +
                            `</td>`;
                        TotalQty += value.order_quantity;
                    });

                    mainTableHtml += ` <td>` + TotalQty + `</td>
                                    </tr>
                                </tbody>
                            </table>`;

                    var html = "";
                    $.each(data.result, function(key1, value) {
                        html +=
                            `<div class="card">\
                        <div class="card-body">\
                            <h5>` +
                            value
                            .fabric_construction
                            .name + ` (` + value.code + `)` +
                            `</h5>`;

                        html +=
                            ` <div class="repeater-group-` + indexToAlphabet(key1) + `">\
                                <div data-repeater-list="group-` + indexToAlphabet(key1) + `">\
                                <div data-repeater-item class="row">\
                                    <div class="mb-3 col-lg-2">\
                                    <label for="article_style_no">Count</label>\
                            <select class="form-control select2" onchange="getData(this,` +
                            key1 + `)" name="count">\
                                    <?php $__currentLoopData = $counts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($count->id); ?>"><?php echo e($count->name); ?></option>\
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>\
                            </div>\
                            <div class="mb-3 col-lg-3">\
                            <label for="article_style_no">Fiber</label>\
                            <select class="form-control select2" name="fiber">\
                                 <?php $__currentLoopData = $fibers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fiber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($fiber->id); ?>"><?php echo e($fiber->name); ?></option>\
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>\
                            </div>\
                            <div class="mb-3 col-lg-2">\
                                <label for="description">Percentage</label>\
                                <input type="number" id="percentage" max="100" onfocusout="calculateKgs(this, ` +
                            key1 + `)" onchange="calculateKgs(this, ` +
                            key1 + `)" required name="percentage" class="form-control"\
                                    placeholder="%" />\
                            </div>\
                            <div class="mb-3 col-lg-2">\
                                <label for="credit_days" class="form-label">Total Kgs</label>\
                                <input type="number" id="total_kgs` + key1 + `" readonly required name="kgs" class="form-control"\
                                    placeholder="Total Kgs" />\
                            </div>\
                            <div class="mb-3 col-lg-2">\
                                <label for="color">Total Bags</label>\
                                <input type="number" id="total_bags` + key1 + `" readonly name="bags" required value=""\
                                    class="form-control" placeholder="Total Bags" />\
                            </div>\
                            <div class="col-lg-1 align-self-center">\
                                <div class="d-grid">\
                                    <span data-repeater-delete type="button"><i\
                                            class="bx bx-trash-alt font-size-20 text-danger verti-timeline"></i></span>\
                                </div>\
                            </div>\
                            </div>\
                             </div>\
                             <div class="row">\
                            <div class="col-md-6">\
                                <input data-repeater-create="group-b" type="button" class="btn btn-success mt-3 mt-lg-0"\
                                    value="Add" />\
                            </div>\
                            </div>\
                            </div>\
                            </div>\
                            </div>
                            `;
                    });
                    var footerTable = `<table class="table footer_table">\
                                <thead>\
                                    <tr>\
                                        <th>Total</th>\
                                        <th></th>\
                                        <th></th>\
                                        <th></th>\
                                        <th></th>\
                                        <th id="sum_kgs">0</th>\
                                        <th id="sum_bags">0</th>\
                                    </tr>\
                                </thead>\
                            </table>`;


                    $('#repeater-container').append(mainTableHtml + html + footerTable);

                    $.each(data.result, function(key1, value) {
                        $('.repeater-group-' + indexToAlphabet(key1) + '').repeater({
                            defaultValues: {
                                'textarea-input': 'foo',
                                'text-input': 'bar',
                                'select-input': 'B',
                                'checkbox-input': ['A', 'B'],
                                'radio-input': 'B'
                            },
                            show: function() {
                                $(this).slideDown();
                                $(this).find('select').each(function() {
                                    $('.select2').select2({
                                        placeholder: "Select"
                                    });
                                });
                            },
                            hide: function(deleteElement) {
                                if (confirm(
                                        'Are you sure you want to delete this element?'
                                    )) {
                                    $(this).slideUp(deleteElement);
                                }
                            },
                            ready: function(setIndexes) {

                            }
                        });
                    });
                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        });

        function indexToAlphabet(index) {
            // The ASCII code for 'a' is 97
            return String.fromCharCode(97 + index);
        }

        function getData(elem, index1) {
            var selected = $(elem).val();
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
                    $('#title-' + index1).html(
                        '<option value="">Select title</option>');
                    $.each(data.result, function(key, value) {
                        $('#title-' + index1).append('<option value="' +
                            value.id + '">' + value.name + '</option>');
                    });

                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        }

        function calculateKgs(elem, index) {
            var percentage = $(elem).val();

            if (percentage > 100) {
                toastr['error']('Percentage limit exceded.');
                $(elem).val(100);
            }

            var total = $('#required_kgs_' + index + '').val();

            if (total == 0) {
                toastr['error']('Pkease define the required qty first.');
            }

            var calculatedKgs = total * (percentage / 100);

            $(elem).closest('[data-repeater-item]').find('[name$="[kgs]"]').val(calculatedKgs.toFixed(2));

            var calculatedBags = calculatedKgs / 45.36;
            $(elem).closest('[data-repeater-item]').find('[name$="[bags]"]').val(calculatedBags.toFixed(2));

            var totalKgs = 0;
            var totalBags = 0;

            $('[data-repeater-item]').each(function() {
                var kgs = parseFloat($(this).find('[name$="[kgs]"]').val()) || 0;
                totalKgs += kgs;

                var bags = parseFloat($(this).find('[name$="[bags]"]').val()) || 0;
                totalBags += bags;
            });
            $('#sum_kgs').text(totalKgs.toFixed(2) + " Kgs");
            $('#sum_bags').text(totalBags.toFixed(2) + " Bags");
        }
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

<?php echo $__env->make('layouts.departments.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\shafi_portal\resources\views/admin/department/yarn_program/edit.blade.php ENDPATH**/ ?>