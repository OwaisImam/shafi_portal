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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['category-list', 'category-create'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-spreadsheet"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Category'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.category.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['items-list', 'items-create'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-list-ul"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Items'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('items-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.items.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['suppliers-list', 'suppliers-create'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-run"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Supplier'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('suppliers-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.suppliers.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['purchase_order-list', 'purchase_order-create'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-cube-alt"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Purchase_Order'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase_order-create')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.purchase_order.create', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.Create'); ?></a></li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase_order-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.purchase_order.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php elseif($department->name == 'Planning'): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['clients-update', 'clients-list', 'clients-view', 'clients-delete', 'clients-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-group"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Clients'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('clients-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.clients.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['range-update', 'range-list', 'range-view', 'range-delete', 'range-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-group"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Range'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('range-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.range.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fabric_construction-update', 'fabric_construction-list', 'fabric_construction-view',
                        'fabric_construction-delete', 'fabric_construction-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-group"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Fabric_Construction'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fabric_construction-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.fabric_construction.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['payment_terms-update', 'payment_terms-list', 'payment_terms-view', 'payment_terms-delete',
                        'payment_terms-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-group"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Payment_Terms'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payment_terms-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.payment_terms.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['article-update', 'article-list', 'article-view', 'article-delete', 'article-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-group"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Article_Style'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('article-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.article.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['job-update', 'job-list', 'job-view', 'job-delete', 'job-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-group"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Jobs'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('job-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.jobs.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['orders-update', 'orders-list', 'orders-view', 'orders-delete', 'orders-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-user"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Orders'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('orders-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.orders.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('orders-create')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.orders.create', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.Create'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/layouts/departments/sidebar.blade.php ENDPATH**/ ?>