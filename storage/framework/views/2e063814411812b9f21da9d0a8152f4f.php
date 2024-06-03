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

<!-- Responsive datatable examples -->
<link
    href="<?php echo e(URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')); ?>"
    rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css"
    href="<?php echo e(URL::asset('build/libs/toastr/build/toastr.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?>
Users
<?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?>
Users List
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
                    <div class="col-sm-8">
                        <div class="text-sm-end">
                            <a href="<?php echo e(route('admin.users.create')); ?>"
                                class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                    class="mdi mdi-plus me-1"></i> New User</a>
                        </div>
                    </div><!-- end col-->
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
<div class="modal fade" id="newContactModal" tabindex="-1" aria-labelledby="newContactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newContactModalLabel">Add Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" class="needs-validation createContact-form" id="createContact-form" novalidate>
                    <div class="row">
                        <div class="col-lg-12">
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
                                        <input class="form-control d-none" value="" id="member-image-input" type="file"
                                            accept="image/png, image/gif, image/jpeg">
                                    </div>
                                    <div class="avatar-lg">
                                        <div class="avatar-title bg-light rounded-circle">
                                            <img src="<?php echo e(URL::asset('build/images/users/user-dummy-img.jpg')); ?>"
                                                id="member-img" class="avatar-md rounded-circle h-auto" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="username-input" class="form-label">User Name</label>
                                <input type="text" id="username-input" class="form-control" placeholder="Enter name"
                                    required />
                                <div class="invalid-feedback">Please enter a name.</div>
                            </div>
                            <div class="mb-3">
                                <label for="designation-input" class="form-label">Designation</label>
                                <input type="text" id="designation-input" class="form-control"
                                    placeholder="Enter Designation" required />
                                <div class="invalid-feedback">Please enter a designation.</div>
                            </div>
                            <div class="mb-3">
                                <label for="email-input" class="form-label">Email</label>
                                <input type="email" id="email-input" class="form-control" placeholder="Enter email"
                                    required />
                                <div class="invalid-feedback">Please enter email.</div>
                            </div>
                            <div class="mb-3">
                                <label for="tag-input" class="form-label">Tags</label>
                                <select class="select2 form-control select2-multiple" id="tag-input" multiple="multiple"
                                    data-placeholder="Choose ...">
                                    <option value="Photoshop">Photoshop</option>
                                    <option value="illustrator">illustrator</option>
                                    <option value="Html">Html</option>
                                    <option value="Css">Css</option>
                                    <option value="Javascript">Javascript</option>
                                    <option value="Php">Php</option>
                                    <option value="Java">Java</option>
                                    <option value="Ruby">Ruby</option>
                                    <option value="Python">Python</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" id="addContact-btn" class="btn btn-success">Add
                                    Customer</button>
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
                    <button type="button" class="btn btn-danger" id="remove-item">Remove Now</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end removeItemModal -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<!-- select2 js -->
<script
    src="<?php echo e(URL::asset('build/libs/select2/js/select2.min.js')); ?>">
</script>
<script
    src="<?php echo e(URL::asset('build/libs/moment/min/moment.min.js')); ?>">
</script>

<!-- Required datatable js -->
<script
    src="<?php echo e(URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js')); ?>">
</script>
<script
    src="<?php echo e(URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>">
</script>

<!-- Responsive examples -->
<script
    src="<?php echo e(URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>">
</script>
<script
    src="<?php echo e(URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')); ?>">
</script>

<!-- ecommerce-customer-list init -->
<script
    src="<?php echo e(URL::asset('build/js/pages/users/user-list.init.js')); ?>">
</script>

<!-- toastr plugin -->
<script
    src="<?php echo e(URL::asset('build/libs/toastr/build/toastr.min.js')); ?>">
</script>
<!-- toastr init -->
<script
    src="<?php echo e(URL::asset('build/js/pages/toastr.init.js')); ?>">
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

<?php echo $__env->make('layouts.master', Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/admin/users/index.blade.php ENDPATH**/ ?>