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

                <?php if($department->slug == 'merchandising'): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-cog"></i>
                            <span key="t-layouts"><?php echo app('translator')->get('translation.Settings'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
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
                        </ul>
                    </li>
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
                <?php elseif($department->slug == 'planning'): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-cog"></i>
                            <span key="t-layouts"><?php echo app('translator')->get('translation.Settings'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['clients-update', 'clients-list', 'clients-view', 'clients-delete',
                                'clients-edit'])): ?>
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
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fabric_construction-update', 'fabric_construction-list',
                                'fabric_construction-view', 'fabric_construction-delete', 'fabric_construction-edit'])): ?>
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
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['payment_terms-update', 'payment_terms-list', 'payment_terms-view',
                                'payment_terms-delete', 'payment_terms-edit'])): ?>
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
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['article-update', 'article-list', 'article-view', 'article-delete',
                                'article-edit'])): ?>
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
                        </ul>
                    </li>
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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['pre_production_plan-update', 'pre_production_plan-list', 'pre_production_plan-view',
                        'pre_production_plan-delete', 'pre_production_plan-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-group"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.Pre_Production_Plan'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pre_production_plan-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.pre_production_plans.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['yarn_program-update', 'yarn_program-list', 'yarn_program-view', 'yarn_program-delete',
                        'yarn_program-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-group"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.YarnProgram'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('yarn_program-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.yarn_program.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('yarn_program-create')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.yarn_program.create', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.Create'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['knitting_program-update', 'knitting_program-list', 'knitting_program-view',
                        'knitting_program-delete', 'knitting_program-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-group"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.KnittingProgram'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('knitting_program-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.knitting_program.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('knitting_program-create')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.knitting_program.create', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.Create'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php elseif($department->slug == 'yarn'): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-cog"></i>
                            <span key="t-layouts"><?php echo app('translator')->get('translation.Settings'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['count-update', 'count-list', 'count-view', 'count-delete', 'count-edit'])): ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="bx bx-user"></i>
                                        <span key="t-users"><?php echo app('translator')->get('translation.Count'); ?></span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('count-list')): ?>
                                            <li><a href="<?php echo e(route('admin.departments.count.index', ['slug' => $department->slug])); ?>"
                                                    key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fiber-update', 'fiber-list', 'fiber-view', 'fiber-delete', 'fiber-edit'])): ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="bx bx-user"></i>
                                        <span key="t-users"><?php echo app('translator')->get('translation.Fiber'); ?></span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fiber-list')): ?>
                                            <li><a href="<?php echo e(route('admin.departments.fiber.index', ['slug' => $department->slug])); ?>"
                                                    key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['terms_of_delivery-update', 'terms_of_delivery-list', 'terms_of_delivery-view',
                                'terms_of_delivery-delete', 'terms_of_delivery-edit'])): ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="bx bx-user"></i>
                                        <span key="t-users"><?php echo app('translator')->get('translation.TermsOfDelivery'); ?></span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('terms_of_delivery-list')): ?>
                                            <li><a href="<?php echo e(route('admin.departments.terms_of_delivery.index', ['slug' => $department->slug])); ?>"
                                                    key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['mills-update', 'mills-list', 'mills-view', 'mills-delete', 'mills-edit'])): ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="bx bx-user"></i>
                                        <span key="t-users"><?php echo app('translator')->get('translation.Mills'); ?></span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('mills-list')): ?>
                                            <li><a href="<?php echo e(route('admin.departments.mill.index', ['slug' => $department->slug])); ?>"
                                                    key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['agents-update', 'agents-list', 'agents-view', 'agents-delete', 'agents-edit'])): ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="bx bx-user"></i>
                                        <span key="t-users"><?php echo app('translator')->get('translation.Agents'); ?></span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agents-list')): ?>
                                            <li><a href="<?php echo e(route('admin.departments.agents.index', ['slug' => $department->slug])); ?>"
                                                    key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['yarn_purchase_order-update', 'yarn_purchase_order-list', 'yarn_purchase_order-view',
                        'yarn_purchase_order-delete', 'yarn_purchase_order-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-user"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.YarnPurchaseOrder'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('yarn_purchase_order-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.yarn_purchase_order.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('yarn_purchase_order-create')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.yarn_purchase_order.create', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.Create'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php elseif($department->slug == 'fabrication'): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-cog"></i>
                            <span key="t-layouts"><?php echo app('translator')->get('translation.Settings'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['knitting-update', 'knitting-list', 'knitting-view', 'knitting-delete',
                                'knitting-edit'])): ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="bx bx-user"></i>
                                        <span key="t-users"><?php echo app('translator')->get('translation.Knitting'); ?></span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('knitting-list')): ?>
                                            <li><a href="<?php echo e(route('admin.departments.knitting.index', ['slug' => $department->slug])); ?>"
                                                    key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['dyeing-update', 'dyeing-list', 'dyeing-view', 'dyeing-delete', 'dyeing-edit'])): ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="bx bx-user"></i>
                                        <span key="t-users"><?php echo app('translator')->get('translation.Dyeing'); ?></span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dyeing-list')): ?>
                                            <li><a href="<?php echo e(route('admin.departments.dyeing.index', ['slug' => $department->slug])); ?>"
                                                    key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>

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

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['cartage_slip-update', 'cartage_slip-list', 'cartage_slip-view', 'cartage_slip-delete',
                        'cartage_slip-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-user"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.CartageSlips'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cartage_slip-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.cartage_slip.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cartage_slip-create')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.cartage_slip.create', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.Create'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php elseif($department->slug == 'general-store'): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['yarn_purchase_order-update', 'yarn_purchase_order-list', 'yarn_purchase_order-view',
                        'yarn_purchase_order-delete', 'yarn_purchase_order-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-user"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.YarnPurchaseOrder'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('yarn_purchase_order-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.yarn_purchase_order.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('yarn_purchase_order-create')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.yarn_purchase_order.create', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.Create'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['yarn_stock-update', 'yarn_stock-list', 'yarn_stock-view', 'yarn_stock-delete',
                        'yarn_stock-edit'])): ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-user"></i>
                                <span key="t-users"><?php echo app('translator')->get('translation.YarnStock'); ?></span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('yarn_stock-list')): ?>
                                    <li><a href="<?php echo e(route('admin.departments.yarn_stock.index', ['slug' => $department->slug])); ?>"
                                            key="t-default"><?php echo app('translator')->get('translation.List'); ?></a></li>
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
<?php /**PATH C:\laragon\www\shafi_portal\resources\views/layouts/departments/sidebar.blade.php ENDPATH**/ ?>