<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>

                <li>
                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Main <?php echo app('translator')->get('translation.Dashboard'); ?></span>
                    </a>
                </li>
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Department_Menu'); ?></li>
                <li>
                    <a href="<?php echo e(route('admin.departments.dashboard', ['slug' => $department->slug])); ?>">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Department <?php echo app('translator')->get('translation.Dashboard'); ?></span>
                    </a>
                </li>

                <?php if($department->name == 'Merchandising'): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-user"></i>
                            <span key="t-users"><?php echo app('translator')->get('translation.Category'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            
                            <li><a href="<?php echo e(route('admin.departments.category.index', ['slug' => $department->slug])); ?>"
                                    key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                            
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-user"></i>
                            <span key="t-users"><?php echo app('translator')->get('translation.Items'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            
                            <li><a href="<?php echo e(route('admin.departments.items.index', ['slug' => $department->slug])); ?>"
                                    key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                            
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-user"></i>
                            <span key="t-users"><?php echo app('translator')->get('translation.Supplier'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            
                            <li><a href="<?php echo e(route('admin.departments.suppliers.index', ['slug' => $department->slug])); ?>"
                                    key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                            

                        </ul>
                    </li>
                <?php elseif($department->name == 'Merchandising'): ?>
                    
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-user"></i>
                            <span key="t-users"><?php echo app('translator')->get('translation.Pre_Production_Plan'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            
                            <li><a href="<?php echo e(route('admin.departments.pre_production_plans.index', ['slug' => $department->slug])); ?>"
                                    key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                            
                            
                            <li><a href="<?php echo e(route('admin.departments.pre_production_plans.create', ['slug' => $department->slug])); ?>"
                                    key="t-default"><?php echo app('translator')->get('translation.Create'); ?></a></li>
                            
                        </ul>
                    </li>
                    
                <?php endif; ?>

                

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/layouts/departments/sidebar.blade.php ENDPATH**/ ?>