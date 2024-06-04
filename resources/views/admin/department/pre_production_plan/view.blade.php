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
                                        <td>{{ $preProductionPlan->order->code }}</td>
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
                                <td>{{ $preProductionPlan->order->job->number }}</td>
                                <td>{{ $preProductionPlan->order->client->name }}</td>
                                <td>{{ $preProductionPlan->order->client->city->state->name }}</td>
                                <td>{{ $preProductionPlan->order->client->address }}</td>
                                <td>{{ $preProductionPlan->order->po_receive_date }}</td>
                                <td>{{ $preProductionPlan->order->delivery_date }}</td>
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
                                <td>{{ $preProductionPlan->order->range->name }}</td>
                                <td>{{ $preProductionPlan->order->fabric_construction->name }}</td>
                                <td>{{ $preProductionPlan->order->gsm }}</td>
                                <td>{{ $preProductionPlan->order->order_quantity . ' ' . $preProductionPlan->order->order_items->first()->unit }}
                                </td>
                                <td>{{ $preProductionPlan->order->article_style_count }}</td>
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
        <input type="hidden" name="order_id" value="{{ $preProductionPlan->order->id }}">

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
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $totalQty = 0;
                                        $totalKgs = 0;
                                        $totalPercentage = 0;
                                    @endphp
                                    @foreach ($preProductionPlan->yarn_purchase_orders as $key => $yarn_purchase_order)
                                        <tr>
                                            <td>{{ $yarn_purchase_order->yarn_purchase_order->count->name . ' ' . $yarn_purchase_order->yarn_purchase_order->fiber->name }}
                                                <input type="hidden" name="yarn_purchase_order[{{ $key }}][id]"
                                                    value="{{ $yarn_purchase_order->id }}">

                                            </td>
                                            <td>{{ $yarn_purchase_order->yarn_purchase_order->unit }}</td>
                                            <td>
                                                <div class="mb-3 col-lg-12">
                                                    <span
                                                        class="qty_{{ $key }} kgs">{{ $yarn_purchase_order->qty }}</span>
                                                </div>
                                            </td>
                                            <td><span
                                                    class="kgs_{{ $key }} kgs">{{ $yarn_purchase_order->kgs }}</span>

                                            </td>
                                            <td>
                                                <span
                                                    class="percentage_{{ $key }} percentage">{{ $yarn_purchase_order->percentage }}%</span>

                                            </td>
                                        </tr>
                                        @php
                                            $totalQty += $yarn_purchase_order->qty;
                                            $totalKgs += $yarn_purchase_order->kgs;
                                            $totalPercentage += $yarn_purchase_order->percentage;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total KGs (Gross)</th>
                                        <th></th>
                                        <th><span id="total-qty">{{ $totalQty }}</span></th>
                                        <th><span id="total-kgs">{{ $totalKgs }}</span></th>
                                        <th><span id="total-percentage">{{ $totalPercentage }}%</span></th>
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
                        <p>Processes</p>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-responsive ">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Process</th>
                                                    <th>Notes</th>
                                                </tr>
                                            </thead>
                                            <tbody class="process-list" id="processes">
                                                @foreach ($preProductionPlan->processes as $key => $process)
                                                    <tr class="align-middle">
                                                        <th>{{ $process->process->name }}
                                                        </th>

                                                        <td>
                                                            <div class=" col-lg-12">
                                                                <p>{{ $process->notes }}</p>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
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

                                            <td>{{ $accessories->item->name }}
                                            </td>
                                            <td>
                                                {{ $accessories->qty }}
                                            </td>
                                            <td>
                                                {{ $accessories->notes }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
