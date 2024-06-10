@extends('layouts.departments.master')

@section('title')
    @lang('translation.Orders')
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
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.Departments')
        @endslot
        @slot('li_2')
            {{ $department->name }}
        @endslot
        @slot('title')
            @lang('translation.YarnPurchaseOrder')
        @endslot
    @endcomponent

    <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST"
        action="{{ route('admin.departments.yarn_purchase_order.update', ['slug' => $department->slug, 'yarn_purchase_order' => $yarn_po->id]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order_id" class="form-label">Order </label>
                                    <select name="order_id" id="order_id" class="form-control select2" required>
                                        <option value="">Select</option>
                                        @foreach ($orders as $order)
                                            <option value="{{ $order->id }}"
                                                {{ $yarn_po->order_id == $order->id ? 'selected' : '' }}>
                                                {{ $order->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid order no.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="job_id" class="form-label">Job No</label>
                                    <select name="job_id" id="job_id" class="form-control select2" required>
                                        <option value="">Select</option>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}"
                                                {{ $yarn_po->job_id == $job->id ? 'selected' : '' }}>{{ $job->number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid job no.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="count_id" class="form-label">Count </label>
                                    <select name="count_id" id="count_id" class="form-control select2" required>
                                        <option value="">Select</option>
                                        @foreach ($counts as $count)
                                            <option value="{{ $count->id }}"
                                                {{ $yarn_po->count_id == $count->id ? 'selected' : '' }}>
                                                {{ $count->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid counts no.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fiber_id" class="form-label">Fiber</label>
                                    <select name="fiber_id" id="fiber_id" class="form-control select2" required>
                                        <option value="">Select</option>
                                        @foreach ($fibers as $fiber)
                                            <option value="{{ $fiber->id }}"
                                                {{ $yarn_po->fiber_id == $fiber->id ? 'selected' : '' }}>
                                                {{ $fiber->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid fiber.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fabric_construction_id" class="form-label">Fabric Construction </label>
                                    <select name="fabric_construction_id" id="fabric_construction_id"
                                        class="form-control select2" required>
                                        <option value="">Select</option>
                                        @foreach ($fabricConstructions as $fabricConstruction)
                                            <option value="{{ $fabricConstruction->id }}"
                                                {{ $yarn_po->fabric_construction_id == $fabricConstruction->id ? 'selected' : '' }}>
                                                {{ $fabricConstruction->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid fiber construction.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mill_id" class="form-label">Mill</label>
                                    <select name="mill_id" id="mill_id"
                                        data-parsley-required-message="You must select at least one option."
                                        class="form-control select2" required>
                                        <option value="">Select</option>
                                        @foreach ($mills as $mill)
                                            <option value="{{ $mill->id }}"
                                                {{ $yarn_po->mill_id == $mill->id ? 'selected' : '' }}>{{ $mill->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid job no.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="agent_id" class="form-label">Agent </label>
                                    <select name="agent_id" id="agent_id" class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach ($agents as $agent)
                                            <option value="{{ $agent->id }}"
                                                {{ $yarn_po->agent_id == $agent->id ? 'selected' : '' }}>
                                                {{ $agent->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid agent.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="terms_of_delivery_id" class="form-label">Terms Of Delivery</label>
                                    <select name="terms_of_delivery_id" id="terms_of_delivery_id"
                                        class="form-control select2" required>
                                        <option value="">Select</option>
                                        @foreach ($termsOfDelivery as $termsOfDeliver)
                                            <option
                                                value="{{ $termsOfDeliver->id }}"{{ $yarn_po->terms_of_delivery_id == $termsOfDeliver->id ? 'selected' : '' }}>
                                                {{ $termsOfDeliver->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid terms of delivery.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="contract_no" class="form-label">Contract No</label>
                                    <input class="form-control" type="number" name="contract_no"
                                        value="{{ $yarn_po->contract_no }}" placeholder="Enter contract no" required
                                        id="contract_no">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid contract no.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 border-end">
                                <div class="mb-3">
                                    <label for="date_of_purchase" class="form-label">Date of Purchase</label>
                                    <div class="input-group" id="date_of_purchase_cont">
                                        <input type="text" class="form-control" placeholder="dd M, yyyy"
                                            value="{{ $yarn_po->date_of_purchase ? $yarn_po->date_of_purchase : date('d M, Y') }}"
                                            id="date_of_purchase" data-date-format="dd M, yyyy" name="date_of_purchase"
                                            data-date-container='#date_of_purchase_cont' data-provide="datepicker">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid purchase date.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="gst_no" class="form-label">Terms of Payment</label>
                                    <div class="input-group">
                                        <input type="number" value="{{ $yarn_po->terms_of_payment }}"
                                            name="terms_of_payment" class="form-control"
                                            placeholder="Enter terms of payment">
                                        <span class="input-group-text">Days</span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid payment terms.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="delivery_date_cont" class="form-label">Delivery Date</label>
                                    <div class="input-group" id="delivery_date_cont">
                                        <input type="text" class="form-control" placeholder="dd M, yyyy"
                                            value="{{ $yarn_po->delivery_date ? $yarn_po->delivery_date : date('d M, Y') }}"
                                            id="delivery_date" data-date-format="dd M, yyyy" name="delivery_date"
                                            data-date-container='#delivery_date_cont'
                                            onchange="calculateCompletionIn(this)" data-provide="datepicker">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid delivery date.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Lbs</label>
                                    <input type="number" class="form-control" onkeyup="calculateKGsBags(this)"
                                        id="lbs" placeholder="Enter Lbs" value="{{ $yarn_po->lbs }}" required
                                        name="lbs">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid lbs.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Kgs</label>
                                    <input type="number" class="form-control" id="kgs" placeholder="Enter Kgs"
                                        value="{{ $yarn_po->kgs }}" readonly required name="kgs">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid kgs.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 border-end">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Bags</label>
                                    <div class="btn-group dropup">
                                        <input type="hidden" name="unit" id="unit"
                                            value="{{ $yarn_po->unit }}">
                                        <input type="number" class="form-control" id="qty"
                                            placeholder="Enter Qty" value="{{ $yarn_po->qty ?: old('qty') }}" readonly
                                            required name="qty">
                                        <button type="button" class="btn btn-primary dropdown-toggle" id="unitButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $yarn_po->unit }}
                                        </button>
                                        <div class="dropdown-menu" id="unitDropdown">
                                            <a class="dropdown-item" href="#" data-unit="Bags">Bags</a>
                                            <a class="dropdown-item" href="#" data-unit="Carton">Carton</a>
                                        </div>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid bags number.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Price/LB</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="price_per_lb"
                                            placeholder="Enter price/lb" onchange="calculateAmount(this)" step="0.10"
                                            value="{{ $yarn_po->price_per_lb }}" required name="price_per_lb">
                                        <span class="input-group-text">Rs</span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid bags number.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Amount</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="amount"
                                            placeholder="Enter amount" readonly value="{{ $yarn_po->amount }}" required
                                            name="amount">
                                        <span class="input-group-text">Rs</span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid amount.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="credit_days" class="form-label">Amount With GST</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="with_gst"
                                            placeholder="Enter amount with gst" readonly value="{{ $yarn_po->with_gst }}"
                                            required name="with_gst">
                                        <span class="input-group-text">Rs</span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid amount with gst.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="completion_in" class="form-label">Completion In</label>
                                    <div class="input-group">
                                        <input type="number" id="completion_in"
                                            value="{{ $yarn_po->completion_in ?: 0 }}" name="completion_in"
                                            class="form-control" readonly placeholder="Enter terms of payment in days">
                                        <span class="input-group-text">Days</span>
                                    </div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid completion time.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 border-end">
                                <div class="mb-3">
                                    <label for="delivered" class="form-label">Delivered</label>
                                    <input type="number" class="form-control" inputmode="kana"
                                        onchange="calculateBalance(this)" placeholder="Enter delivered"
                                        value="{{ $yarn_po->delivered }}" name="delivered" step="0.01" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid delivered count.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="balance" class="form-label">Balance</label>
                                    <input type="number" placeholder="Enter balance" name="balance"
                                        class="form-control" id="balance" value="{{ $yarn_po->balance }}" readonly
                                        required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Select the valid balance.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="invoice_of" class="form-label">Invoice of</label>
                                    <input class="form-control" type="text" name="invoice_of"
                                        value="{{ $yarn_po->invoice_of ?: old('invoice_of') }}"
                                        placeholder="Enter invocie of" required id="invoice_of">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid invoice of.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea type="number" placeholder="Enter remarks" name="remarks" class="form-control" id="remarks">{{ $yarn_po->remarks }}</textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid remarks.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="submit">Update</button>
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

    <script src="{{ URL::asset('build/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/order-form-repeaterr.int.js') }}"></script>
    <script src="{{ URL::asset('build/libs/table-edits/build/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/table-editable.int.js') }}"></script>
    <script>
        function calculateKGsBags(input) {
            var kgs = 0;
            var lbs = $(input).val();
            kgs = lbs / 2.20462262;
            var bags = kgs / 45.359237;
            $('#kgs').val(parseFloat(kgs).toFixed(2));
            $('#bags').val(parseFloat(bags).toFixed(2));
        }

        function calculateAmount(input) {
            var amount_per_lbs = $(input).val();
            var lbs = $('#lbs').val();
            var amount = amount_per_lbs * lbs;
            $('#amount').val(parseFloat(amount).toFixed(2));
            var with_gst = amount * (1 + 0.18);
            $('#with_gst').val(parseFloat(with_gst).toFixed(2));
        }

        function calculateBalance(input) {
            var delivered = $(input).val();
            var bags = $('#bags').val();

            if (bags == "") {
                toastr["error"]('Please define the bags first');
                return;
            }
            $(input).attr({
                "max": bags,
                "min": 0
            });

            var balance = bags - delivered;
            $('#balance').val(parseFloat(balance).toFixed(2));
        }

        function calculateCompletionIn(input) {
            var delivery_date = $(input).val();
            var purchase_date = $('#date_of_purchase').val();

            // Ensure both dates are provided
            if (delivery_date && purchase_date) {

                // Convert the date strings to Date objects
                var deliveryDateObj = new Date(delivery_date);
                var purchaseDateObj = new Date(purchase_date);

                // Calculate the difference in time (milliseconds)
                var timeDifference = deliveryDateObj - purchaseDateObj;

                // Convert the time difference from milliseconds to days
                var differenceInDays = timeDifference / (1000 * 60 * 60 * 24);

                // Set the difference in days to the input field
                $('#completion_in').val(differenceInDays);
            } else {
                toastr["error"]('Please provide both dates');
            }
        }

        $(document).ready(function() {
            $('#unitDropdown .dropdown-item').on('click', function(event) {
                event.preventDefault();
                var selectedUnit = $(this).data('unit');
                $('#unit').val(selectedUnit);
                $('#unitButton').text(selectedUnit);
            });
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
