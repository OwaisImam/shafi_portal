<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['users-update', 'users-list', 'users-view', 'users-delete', 'users-edit'])): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-home-circle"></i>
                            <span key="t-dashboards"><?php echo app('translator')->get('translation.Users'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users-list')): ?>
                                <li><a href="<?php echo e(route('admin.users.index')); ?>" key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users-create')): ?>
                                <li><a href="<?php echo e(route('admin.users.create')); ?>" key="t-default"><?php echo app('translator')->get('translation.Create'); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>