@extends('layouts.departments.master')

@section('title')
    @lang('translation.Pre_Production_Plan')
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('build/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/toastr/build/toastr.min.css') }}">
    <link href="{{ URL::asset('build/libs/dragula/dragula.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pre Production Plan
        @endslot
        @slot('title')
            Create Pre Production Plan
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5>Order Details</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-responsive table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Order Code</th>
                                        <td>{{ $order->code }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Job ID</th>
                                <th>Client Name</th>
                                <th>State</th>
                                <th>Shipping Address</th>
                                <th>PO Receive Date</th>
                                <th>Delivery Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $order->job->number }}</td>
                                <td>{{ $order->client->name }}</td>
                                <td>{{ $order->client->city->state->name }}</td>
                                <td>{{ $order->client->address }}</td>
                                <td>{{ $order->po_receive_date }}</td>
                                <td>{{ $order->delivery_date }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Range</th>
                                <th>Fabric Construction</th>
                                <th>GSM</th>
                                <th>Total Order Quantity</th>
                                <th>Total Article Style</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $order->range->name }}</td>
                                <td>{{ $order->fabric_construction->name }}</td>
                                <td>{{ $order->gsm }}</td>
                                <td>{{ $order->order_quantity . ' ' . $order->order_items->first()->unit }}</td>
                                <td>{{ $order->article_style_count }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
    <form
        action="{{ route('admin.departments.pre_production_plans.update', ['slug' => $department->slug, 'pre_production_plan' => $preProductionPlan->id]) }}"
        method="Post">
        @csrf
        @method('PUT')
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Section 1</h4>
                        <p>Yarn Booking</p>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Yarn</th>
                                        <th>Unit</th>
                                        <th>Qty</th>
                                        <th>Kgs</th>
                                        <th>%</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($yarn_purchase_orders as $key => $yarn_purchase_order)
                                        <tr>
                                            <td>{{ $yarn_purchase_order->count->name . ' ' . $yarn_purchase_order->fiber->name }}
                                                <input type="hidden" name="yarn_purchase_order[{{ $key }}][id]"
                                                    value="{{ $yarn_purchase_order->id }}">

                                            </td>
                                            <td>{{ $yarn_purchase_order->unit }}</td>
                                            <td>
                                                <div class="mb-3 col-lg-12">
                                                    <input type="number"
                                                        name="yarn_purchase_order[{{ $key }}][qty]"
                                                        onchange="calculateTotalQty(this, {{ $key }} )"
                                                        step="0.01" class="form-control qty"
                                                        value="{{ $preProductionPlan->yarn_purchase_orders->where('yarn_purchase_order_id', $yarn_purchase_order->id)->first()?->qty }}"
                                                        max="{{ $yarn_purchase_order->qty }}" required
                                                        placeholder="Enter qty">
                                                </div>
                                            </td>
                                            <td><span class="kgs_{{ $key }} kgs">0</span>
                                                <input type="hidden" name="yarn_purchase_order[{{ $key }}][kgs]"
                                                    required class="kgs_field_{{ $key }}">
                                            </td>
                                            <td>
                                                <span class="percentage_{{ $key }} percentage">0%</span>
                                                <input type="hidden"
                                                    name="yarn_purchase_order[{{ $key }}][percentage]" required
                                                    class="percentage_field_{{ $key }}">
                                            </td>
                                            <td>
                                                <span class="balance_{{ $key }} balance">0</span>
                                                <input type="hidden"
                                                    name="yarn_purchase_order[{{ $key }}][balance]" required
                                                    class="balance_field_{{ $key }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total KGs (Gross)</th>
                                        <th></th>
                                        <th><span id="total-qty">0</span></th>
                                        <th><span id="total-kgs">0</span></th>
                                        <th><span id="total-percentage">0</span></th>
                                        <th><span id="total-balance">0</span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Section 2</h4>
                        <p>Define Process</p>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-responsive ">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Process</th>
                                                    <th>Want to add?</th>
                                                    <th>Notes</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="process-list" id="processes">
                                                @foreach ($processes as $key => $process)
                                                    <tr class="align-middle" id="NewprocessForm{{ $process->id }}">
                                                        <th>{{ $process->name }}
                                                        </th>
                                                        <td>
                                                            <div class="col-lg-12">
                                                                <div class="form-check form-check-primary">
                                                                    <input type="hidden"
                                                                        name="processes[{{ $key }}][parent_process_id]"
                                                                        value="">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="processes[{{ $key }}][id]"
                                                                        value="{{ $process->id }}"
                                                                        {{ $preProductionPlan->processes->where('process_id', $process->id)->first() ? 'checked' : '' }}
                                                                        id="formCheckcolor{{ $key }}">
                                                                    <label class="form-check-label"
                                                                        for="formCheckcolor{{ $key }}">
                                                                        Yes
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class=" col-lg-12">
                                                                <input type="text" id="notes{{ $key }}"
                                                                    name="processes[{{ $key }}][notes]"
                                                                    value="{{ $preProductionPlan->processes->where('process_id', $process->id)->first()?->notes }}"
                                                                    class="form-control" placeholder="Notes" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($process->is_default == 0)
                                                                <a
                                                                    href="{{ route('admin.departments.processes.destroy', ['slug' => $department->slug, 'process' => $process->id]) }}"><i
                                                                        class="bx bx-trash-alt text-danger"></i></a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if ($loop->last)
                                                        <input type="hidden" id="last_index"
                                                            value="{{ $key }}">
                                                    @endif
                                                @endforeach

                                            </tbody>
                                        </table>
                                        <div class="text-center d-grid col-3">
                                            <a href="javascript: void(0);"
                                                class="btn btn-success waves-effect waves-light addProcess-btn"
                                                data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg"
                                                data-id="#processes"><i class="mdi mdi-plus me-1"></i> Add New</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Section 2</h4>
                        <p>Accessories arrangement</p>
                        <div class="table-responsice">
                            <table class="table" id="accessories_table">
                                <thead>
                                    <th>Item Category</th>
                                    <th>Req Quantity</th>
                                    <th>Note</th>
                                </thead>
                                <tbody>
                                    @foreach ($preProductionPlan->accessories as $key => $accessories)
                                        <tr>

                                            <td><input type="hidden" name="accessories[{{ $key }}][item_id]"
                                                    value="{{ $accessories->item_id }}"> {{ $accessories->item->name }}
                                            </td>
                                            <td>
                                                <div class="col-lg-12">
                                                    <div class="form-check form-check-primary">
                                                        <input type="number" placeholder="Required Qty"
                                                            name="accessories[{{ $key }}][qty]"
                                                            value="{{ $accessories->qty }}" class="form-control">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <textarea class="form-control" placeholder="Notes" name="accessories[{{ $key }}][notes]">{{ $accessories->notes }}</textarea>
                                            </td>
                                            <td>
                                                <div class="dropdown float-end">
                                                    <a href="#" class="dropdown-toggle arrow-none"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item editaccessories-details" href="#"
                                                            id="accessoriesedit" data-id="" data-bs-toggle="modal"
                                                            data-bs-target=".bs-accessories-modal-lg">Edit</a>
                                                        <a class="dropdown-item deleteaccessories" href="#"
                                                            data-id="">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                            @if ($loop->last)
                                                <input type="hidden" id="accessories_last_index"
                                                    value="{{ $key }}">
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center d-grid col-3">
                                <a href="javascript: void(0);"
                                    class="btn btn-success waves-effect waves-light addAccessories-btn"
                                    data-bs-toggle="modal" data-bs-target=".bs-accessories-modal-lg"
                                    data-id="#accessories"><i class="mdi mdi-plus me-1"></i> Add New</a>
                            </div>

                        </div>
                        <div class="mt-4">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div id="modalForm" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 add-process-title">Add New Process</h5>
                    <h5 class="modal-title mt-0 update-process-title" style="display: none;">Update
                        Process</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="NewprocessForm" role="form">
                        <div class="form-group mb-3">
                            <label for="processname" class="col-form-label">Process Name<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <input id="processname" name="processname" type="text" class="form-control validate"
                                    placeholder="Enter Process Name..." required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="col-form-label">Parent Process</label>
                            <div class="col-lg-12">
                                <select class="form-select validate" id="ParentProcess">
                                    <option value="" selected>Choose..</option>
                                    @foreach ($processes as $key => $process)
                                        <option value="{{ $process->id }}">{{ $process->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-10">
                                <button type="button" class="btn btn-primary" id="addprocess">Create
                                    Process</button>
                                <button type="button" class="btn btn-primary" id="updateprocessdetail">Update
                                    Process</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="accessoriesModalForm" class="modal fade bs-accessories-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0 add-accessories-title">Add New Item</h5>
                    <h5 class="modal-title mt-0 update-accessories-title" style="display: none;">Update
                        Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="NewaccessoriesForm" role="form">
                        <div class="form-group mb-4">
                            <label class="col-form-label">Item<span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <select class="form-select validate" required id="accessories">
                                    <option value="" selected>Choose..</option>
                                    @foreach ($items as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="col-form-label">Require Qty<span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <input type="number" id="required_qty" required class="form-control validate">
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="col-form-label">Notes</label>
                            <div class="col-lg-12">
                                <textarea id="accessories_notes" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-10">
                                <button type="button" class="btn btn-primary" id="addaccessories">Add
                                    Item</button>
                                <button type="button" class="btn btn-primary" id="updateaccessoriesdetail">Update
                                    Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/inputmask/inputmask.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/inputmask/jquery.inputmask.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-mask.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
    <!-- form advanced init -->
    <script src="{{ URL::asset('build/libs/toastr/build/toastr.min.js') }}"></script>
    <!-- toastr init -->
    <script src="{{ URL::asset('build/js/pages/toastr.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/dragula/dragula.min.js') }}"></script>

    <!-- jquery-validation -->
    <script src="{{ URL::asset('build/libs/jquery-validation/jquery.validate.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/task-kanban.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/process-form.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/accessories-form.init.js') }}"></script>

    <script>
        function calculateTotalQty(input, index) {
            const maxValue = parseFloat(input.max);
            const currentValue = parseFloat(input.value);

            if (currentValue > maxValue) {
                toastr["error"](`Qty should not be greater than ${maxValue}`);
                input.value = '';
                return;
            }
            var total = 0;
            var balance = 0;
            var totalKgs = 0;
            var totalPercentage = 0;
            var totalBalance = 0;

            $('.qty').each(function() {
                total += Number($(this).val()) || 0;
            });

            $('#total-qty').text(Number(total).toFixed(2));

            var kgs = Number($(input).val()) * 45.359237;

            $('.kgs_' + index).text(Number(kgs).toFixed(2));
            $('.kgs_field_' + index).val(Number(kgs).toFixed(2));

            balance = maxValue - Number($(input).val());

            $('.balance_' + index).text(Number(balance).toFixed(2));
            $('.balance_field_' + index).val(Number(balance).toFixed(2));

            $('.balance').each(function() {
                totalBalance += Number($(this).text());
            });

            $('.kgs').each(function() {
                totalKgs += Number($(this).text()) || 0;
            });

            $('.kgs').each(function(index) {
                var percentage = (Number($(this).text()) / totalKgs) * 100;
                totalPercentage += percentage;
                $('.percentage_' + index).text(Number(percentage).toFixed(2));
                $('.percentage_field_' + index).val(Number(percentage).toFixed(2));
            });

            $('#total-kgs').text(Number(totalKgs).toFixed(2));
            $('#total-balance').text(Number(totalBalance).toFixed(2));

            $('#total-percentage').text(Number(totalPercentage).toFixed(2));

        }

        $(document).ready(function() {
            $('input[name^="yarn_purchase_order"][name$="[qty]"]').trigger('change');
        });
    </script>

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr["error"]('{{ $error }}');
            @endforeach
        </script>
    @endif
    @if (session('success'))
        <script>
            toastr["success"]('{{ session('success') }}');
        </script>
    @endif
    @if (session('error'))
        <script>
            toastr["error"]('{{ session('error') }}');
        </script>
    @endif
@endsection
