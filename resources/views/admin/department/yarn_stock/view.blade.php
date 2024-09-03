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
            @lang('translation.YarnStock')
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
                                        <td>{{ $yarnStock->yarn_purchase_order->order->code }}</td>
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
                                <td>{{ $yarnStock->yarn_purchase_order->order->job->number }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order->order->client->name }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order->order->client->city->state->name }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order->order->client->address }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order->order->po_receive_date }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order->order->delivery_date }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Fabric Construction</th>
                                <th>Total Order Quantity</th>
                                <th>Total Article Style</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $yarnStock->yarn_purchase_order->order?->fabric_construction?->name }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order->order->order_quantity . ' ' . $yarnStock->yarn_purchase_order->order->order_items->first()->unit }}
                                </td>
                                <td>{{ $yarnStock->yarn_purchase_order->order->article_style_count }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5>Yarn Purchase Order Details</h5>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Fabric Construction</th>
                                <th>Fiber</th>
                                <th>Count</th>
                                <th>Terms Of Delivery</th>
                                <th>Agent</th>
                                <th>Lbs</th>
                                <th>Kgs</th>
                                <th>Created At</th>
                                <th>Delivery Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $yarnStock->yarn_purchase_order?->fabric_construction?->name }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order?->fiber?->name }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order?->count?->name }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order?->terms_of_delivery?->name }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order?->agent?->name }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order->lbs }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order->kgs }}</td>
                                <td>{{ \Carbon\Carbon::parse($yarnStock->yarn_purchase_order->created_at)->format('Y-m-d') }}</td>
                                <td>{{ $yarnStock->yarn_purchase_order->delivery_date }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5>Yarn Stock Details</h5>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Received From</th>
                                    <th>Delivered To</th>
                                    <th>Total Qty</th>
                                    <th>Received Qty</th>
                                    <th>Remaining Qty</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ isset($yarnStock->delivery_from?->company_name) ?: 'Company'  }}</td>
                                    <td>{{ $yarnStock->delivery_to?->company_name ?: $yarnStock->delivery_to?->name }}</td>
                                    <td>{{ $yarnStock->total_qty }} Kgs</td>
                                    <td>{{ $yarnStock->received_qty }} Kgs</td>
                                    <td>{{ $yarnStock->remaining_qty }} Kgs</td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-primary font-size-11">
                                            {{ $yarnStock->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-primary font-size-11">
                                            {{ $yarnStock->type }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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

    <script src="{{ URL::asset('build/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/order-form-repeaterr.int.js') }}"></script>
    <script src="{{ URL::asset('build/libs/table-edits/build/table-edits.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/table-editable.int.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $('#received_qty').on('keyup focusout', function(event) {
            var receivedQty = parseFloat($(this).val()) || 0; // Convert to float and handle empty input
            var totalQty = parseFloat($('#total_qty').val()) || 0; // Convert to float and handle empty input
            var maxQty = parseFloat($(this).attr('max')) ||
            totalQty; // Get max attribute value or default to totalQty

            // Check if receivedQty exceeds max and adjust if necessary
            if (receivedQty > maxQty) {
                receivedQty = maxQty;
                $(this).val(receivedQty.toFixed(2)); // Set to max value
            }

            $('#remaining_qty').val((totalQty - receivedQty).toFixed(2));
        });

        $('#from-type-input').on('change', function(event) {
            event.preventDefault();
            var selected = $(this).val();
            $.ajax({
                url: "/admin/fetch-data-by-type",
                type: 'GET',
                dataType: 'json',
                data: {
                    "type": selected
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data, status, xhr) {
                    $('#delivery-from-input').html(
                        '<option value="">Select delivery from</option>');
                    if (selected == "departments") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-from-input").append('<option value="' +
                                value.id + '">' + value.name + '</option>');
                        });
                    } else if (selected == "knitting") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-from-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    } else if (selected == "dyeing") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-from-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    }
                    if (selected == 'company') {
                        $('#delivery-from-div').hide();
                        $('#delivery-from-input').removeAttr('required');
                    } else {
                        $('#delivery-from-div').show();
                    }

                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
            });
        });

        $('#to-type-input').on('change', function(event) {
            event.preventDefault();
            var selected = $(this).val();
            $.ajax({
                url: "/admin/fetch-data-by-type",
                type: 'GET',
                dataType: 'json',
                data: {
                    "type": selected
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data, status, xhr) {
                    $('#delivery-to-input').html(
                        '<option value="">Select delivery to</option>');
                    if (selected == "departments") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-to-input").append('<option value="' +
                                value.id + '">' + value.name + '</option>');
                        });
                    } else if (selected == "knitting") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-to-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    } else if (selected == "dyeing") {
                        $.each(data.result, function(key, value) {
                            $("#delivery-to-input").append('<option value="' +
                                value.id + '">' + value.company_name + '</option>');
                        });
                    }

                },
                error: function(xhr, status, error) {
                    callback(xhr.status, xhr.responseJSON);
                }
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
