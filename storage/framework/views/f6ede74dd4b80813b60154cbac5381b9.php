<?php $__env->startSection('title'); ?>
<?php echo app('translator')->get('translation.Data_Tables'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<!-- select2 css -->
<link
    href="<?php echo e(URL::asset('build/libs/select2/css/select2.min.css')); ?>"
    rel="stylesheet" type="text/css" />

<!-- DataTables -->
<link
    href="<?php echo e(URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')); ?>"
    rel="stylesheet" type="text/css" />

<link
    href="<?php echo e(URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')); ?>"
    rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link
    href="<?php echo e(URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')); ?>"
    rel="stylesheet" type="text/css" />
<meta name="department"
    content="<?php echo e($department->slug); ?>">

<link rel="stylesheet" type="text/css"
    href="<?php echo e(URL::asset('build/libs/toastr/build/toastr.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?>
Clients
<?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?>
Clients List
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="search-box me-2 mb-2 d-inline-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" id="searchTableList" placeholder="Search...">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </div>
                    <?php if (app(Illuminate\Contracts\Auth\Access\Gate::class)->check('clients-create')): ?>
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#newClientModal"
                                class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                    class="mdi mdi-plus me-1"></i> New Client</button>
                        </div>
                    </div><!-- end col-->
                    <?php endif; ?>

                </div>
                <!-- end row -->
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-hover dt-responsive nowrap w-100"
                        id="userList-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 40px;">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">City</th>
                                <th scope="col">Postal Code</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created At</th>
                                <th scope="col" style="width: 200px;">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- end table -->
                </div>
                <!-- end table responsive -->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newClientModal" tabindex="-1" aria-labelledby="newClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newClientModalLabel">Add Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off"
                    action="<?php echo e(route('admin.departments.clients.store', ['slug' => $department->slug])); ?>"
                    enctype="multipart/form-data" class="needs-validation createContact-form" id="createContact-form"
                    novalidate method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <input type="hidden" class="form-control" id="userid-input">
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <div class="position-absolute bottom-0 end-0">
                                    <label for="member-image-input" class="mb-0" data-bs-toggle="tooltip"
                                        data-bs-placement="right" title="Select Member Image">
                                        <div class="avatar-xs">
                                            <div
                                                class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                <i class="bx bxs-image-alt"></i>
                                            </div>
                                        </div>
                                    </label>
                                    <input class="form-control d-none" value="" name="logo" id="member-image-input"
                                        type="file" accept="image/png, image/gif, image/jpeg">
                                </div>
                                <div class="avatar-lg">
                                    <div class="avatar-title bg-light rounded-circle">
                                        <img src="<?php echo e(URL::asset('build/images/users/user-dummy-img.jpg')); ?>"
                                            id="member-img" class="avatar-md rounded-circle h-auto" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="username-input" class="form-label">Client Name</label>
                                <input type="text" id="username-input"
                                    value="<?php echo e(old('name')); ?>"
                                    name="name" class="form-control" placeholder="Enter name" required />
                                <div class="invalid-feedback">Please enter a name.</div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="email-input" class="form-label">Email</label>
                                <input type="email" id="email-input"
                                    value="<?php echo e(old('email')); ?>"
                                    class="form-control" placeholder="Enter email" required name="email" />
                                <div class="invalid-feedback">Please enter email.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code-input" class="form-label">Code</label>
                                <input type="text" id="code-input"
                                    value="<?php echo e(old('code')); ?>"
                                    name="code" class="form-control" placeholder="Enter code" required />
                                <div class="invalid-feedback">Please enter a code.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="label-input" class="form-label">Label</label>
                                <input type="text" id="label-input"
                                    value="<?php echo e(old('label')); ?>"
                                    class="form-control" placeholder="Enter label" name="label" />
                                <div class="invalid-feedback">Please enter valid label.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="address-input" class="form-label">Address</label>
                                <input type="text" id="address-input" class="form-control" placeholder="Enter Address"
                                    value="<?php echo e(old('address')); ?>"
                                    name="address" required />
                                <div class="invalid-feedback">Please enter address.</div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="postalcode-input" class="form-label">Postal Code</label>
                                <input type="text" id="postalcode-input" class="form-control"
                                    placeholder="Enter Postal Code"
                                    value="<?php echo e(old('postal_code')); ?>"
                                    name="postal_code" required />
                                <div class="invalid-feedback">Please enter postal code.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                <select class="form-control select2" id="country">
                                    <option>Select</option>
                                    <?php $__currentLoopData = $countries;
$__env->addLoop($__currentLoopData);
foreach($__currentLoopData as $country): $__env->incrementLoopIndices();
    $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($country->id); ?>">
                                        <?php echo e($country->name); ?>
                                    </option>
                                    <?php endforeach;
$__env->popLoop();
$loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="state" class="form-label">State</label>
                                <select class="select2 form-control" id="state" data-placeholder="Choose ...">
                                    <option>Select</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <select class="select2 form-control" name="city_id" id="city" required
                                    data-placeholder="Choose ...">
                                    <option>Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="phone-input" class="form-label">Phone Number</label>
                                <input type="text" id="phone-input" class="form-control"
                                    placeholder="Enter Phone Number"
                                    value="<?php echo e(old('phone_number')); ?>"
                                    name="phone_number" required />
                                <div class="invalid-feedback">Please enter phone number.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="website-input" class="form-label">Website</label>
                                <input type="text" id="website-input" class="form-control" placeholder="Enter Website"
                                    required
                                    value="<?php echo e(old('website')); ?>"
                                    name="website" />
                                <div class="invalid-feedback">Please enter website.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type-input" class="form-label">Sourcing Type</label>
                                <div class="form-check form-radio-primary mb-3">
                                    <input class="form-check-input" type="radio"
                                        <?php echo e(old('type') == 'direct' ? 'checked' : ''); ?>
                                    value="direct" name="type"
                                    id="direct" checked>
                                    <label class="form-check-label" for="direct">
                                        Direct
                                    </label>
                                </div>
                                <div class="form-check form-radio-primary mb-3">
                                    <input class="form-check-input" type="radio"
                                        <?php echo e(old('type') == 'indirect' ? 'checked' : ''); ?>
                                    value="indirect"
                                    name="type" id="indirect" checked>
                                    <label class="form-check-label" for="indirect">
                                        Indirect
                                    </label>
                                </div>
                                <div class="invalid-feedback">Please select sourcing type.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="addContact-btn" class="btn btn-success">Add
                                Client</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
        <!-- end modal body -->
    </div>
    <!-- end modal-content -->
</div>
<!-- end modal-dialog -->
</div>
<!-- end newContactModal -->

<!-- removeItemModal -->
<div class="modal fade" id="removeItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body px-4 py-5 text-center">
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="avatar-sm mb-4 mx-auto">
                    <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                        <i class="mdi mdi-trash-can-outline"></i>
                    </div>
                </div>
                <p class="text-muted font-size-16 mb-4">Are you Sure You Want To Remove This Record ?</p>

                <div class="hstack gap-2 justify-content-center mb-0">
                    <button type="button" class="btn btn-danger" id="remove-item">Remove
                        Now</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end removeItemModal -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script
    src="<?php echo e(URL::asset('build/libs/select2/js/select2.min.js')); ?>">
</script>

<!-- Required datatable js -->
<script
    src="<?php echo e(URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js')); ?>">
</script>
<script
    src="<?php echo e(URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>">
</script>

<!-- ecommerce-customer-list init -->
<script
    src="<?php echo e(URL::asset('build/js/pages/clients/clients-list.init.js')); ?>">
</script>

<!-- select2 js -->
<script
    src="<?php echo e(URL::asset('build/libs/inputmask/inputmask.min.js')); ?>">
</script>
<script
    src="<?php echo e(URL::asset('build/libs/inputmask/jquery.inputmask.min.js')); ?>">
</script>
<script
    src="<?php echo e(URL::asset('build/libs/moment/min/moment.min.js')); ?>">
</script>

<script
    src="<?php echo e(URL::asset('build/js/pages/form-mask.init.js')); ?>">
</script>
<script
    src="<?php echo e(URL::asset('build/libs/parsleyjs/parsley.min.js')); ?>">
</script>
<script
    src="<?php echo e(URL::asset('build/js/pages/form-validation.init.js')); ?>">
</script>
<script
    src="<?php echo e(URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')); ?>">
</script>


<!-- toastr plugin -->
<script
    src="<?php echo e(URL::asset('build/libs/toastr/build/toastr.min.js')); ?>">
</script>
<!-- toastr init -->
<script
    src="<?php echo e(URL::asset('build/js/pages/toastr.init.js')); ?>">
</script>

<script>
    $(document).ready(function() {
        $('#country').on('change', function() {
            var idCountry = this.value;
            $("#seachable-select-state").html('');
            $.ajax({
                url: "<?php echo e(route('admin.fetch.states')); ?>",
                type: "POST",
                data: {
                    country_id: idCountry,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function(result) {
                    $('#state').html(
                        '<option value="">Select State</option>');
                    $.each(result.states, function(key, value) {
                        $("#state").append('<option value="' +
                            value.id + '">' + value.name + '</option>');
                    });
                    $('#seachable-select-city').html(
                        '<option value="">Select City</option>');

                }
            });
        });

        $('#state').on('change', function() {
            var idState = this.value;
            $("#seachable-select-city").html('');
            $.ajax({
                url: "<?php echo e(route('admin.fetch.cities')); ?>",
                type: "POST",
                data: {
                    state_id: idState,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function(res) {
                    $('#city').html(
                        '<option value="">Select City</option>');
                    $.each(res.cities, function(key, value) {
                        $("#city").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        });
    });
</script>

<?php if($errors->any()): ?>
<script>
    <?php $__currentLoopData = $errors->all();
    $__env->addLoop($__currentLoopData);
    foreach($__currentLoopData as $error): $__env->incrementLoopIndices();
        $loop = $__env->getLastLoop(); ?>
    toastr["error"]('<?php echo e($error); ?>');
    <?php endforeach;
    $__env->popLoop();
    $loop = $__env->getLastLoop(); ?>
</script>
<?php endif; ?>
<?php if(session('success')): ?>
<script>
    toastr["success"](
        '<?php echo e(session('success')); ?>');
</script>
<?php endif; ?>
<?php if(session('error')): ?>
<script>
    toastr["error"]('<?php echo e(session('error')); ?>');
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.departments.master', Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/admin/clients/index.blade.php ENDPATH**/ ?>