<?php $__env->startSection('title'); ?>
<?php echo app('translator')->get('translation.Agents'); ?>
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
<meta name="department"
    content="<?php echo e($department->slug); ?>">
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
Agents
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
                            <button type="button" data-bs-toggle="modal" data-bs-target="#newAgentModal"
                                class="btn btn-success btn-rounded waves-effect waves-light addAgent-modal mb-2"><i
                                    class="mdi mdi-plus me-1"></i> New Agent</button>
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
                                <th scope="col">Company Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
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
<div class="modal fade" id="newAgentModal" tabindex="-1" aria-labelledby="newAgentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAgentModalLabel">Add Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" method="POST" class="needs-validation createAgent-form"
                    enctype="multipart/form-data" id="createAgent-form"
                    action="<?php echo e(route('admin.departments.agents.store', ['slug' => $department->slug])); ?>"
                    novalidate>
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" class="form-control" id="agentId-input">
                            <div class="mb-3">
                                <label for="name-input" class="form-label">Name</label>
                                <input type="text" name="name" id="name-input" class="form-control"
                                    placeholder="Enter name" required />
                                <div class="invalid-feedback">Please enter a name.</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <input type="hidden" class="form-control" id="agentId-input">
                            <div class="mb-3">
                                <label for="company_name-input" class="form-label">Company Name</label>
                                <input type="text" name="company_name" id="company_name-input" class="form-control"
                                    placeholder="Enter company name" required />
                                <div class="invalid-feedback">Please enter a company name.</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <input type="hidden" class="form-control" id="agentId-input">
                            <div class="mb-3">
                                <label for="email-input" class="form-label">Email</label>
                                <input type="email" name="email" id="email-input" class="form-control"
                                    placeholder="Enter email" required />
                                <div class="invalid-feedback">Please enter a valid email.</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <input type="hidden" class="form-control" id="agentId-input">
                            <div class="mb-3">
                                <label for="phone-input" class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone-input" class="form-control"
                                    placeholder="Enter phone" required />
                                <div class="invalid-feedback">Please enter a phone number.</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="name-input" class="form-label">Status</label>
                                <div>
                                    <input type="checkbox" name="status" value="1" id="switch6" switch="primary" />
                                    <label for="switch6" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" id="addAgent-btn" class="btn btn-success">Add
                                    Agent</button>
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

<!-- removeAgentModal -->
<div class="modal fade" id="removeAgentModal" tabindex="-1" aria-hidden="true">
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
                    <button type="button" class="btn btn-danger" id="remove-agent">Remove Now</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end removeAgentModal -->
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

<script
    src="<?php echo e(URL::asset('build/js/pages/agents/agents-list.init.js')); ?>">
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

<?php echo $__env->make('layouts.departments.master', Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/admin/department/agent/index.blade.php ENDPATH**/ ?>